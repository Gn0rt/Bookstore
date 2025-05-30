<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/cart.php');
?>
<?php 

    class order {
        private $db;
        private $cart;
        
        public function __construct() {
            $this->db = new Database();
            $this->cart = new cart();
        }
        public function createNewOrderVNPAY($usid, $paymentMethod = 'COD') {
            $id = mysqli_real_escape_string($this->db->link, $usid);
            $cartItems = $this->cart->getCartByUserId($id);
            $grandtotal = 0;
            $items = [];
            
            while ($item = $cartItems->fetch_assoc()) {
                // Kiểm tra số lượng tồn kho
                $currentStock = $this->getProductStock($item['product_id']);
                if ($currentStock < $item['quantity']) {
                    throw new Exception("Sản phẩm {$item['pdname']} chỉ còn {$currentStock} sản phẩm");
                }
        
                $productTotal = $item['price'] * $item['quantity'] * (1 - $item['sale']);
                $grandtotal += $productTotal;
                $items[] = $item;
            }
        
            // Câu lệnh SQL để lưu thông tin đơn hàng
            $order_insert = "INSERT INTO orders (user_id, total_price, status, payment_method) VALUES ('$id', '$grandtotal', 'pending', '$paymentMethod')";
            $this->db->insert($order_insert);
        
            // Lấy ID đơn hàng vừa tạo bằng cách query lại
            $getLastIdQuery = "SELECT LAST_INSERT_ID() as last_id";
            $result = $this->db->select($getLastIdQuery);
            $row = $result->fetch_assoc();
            $orderId = $row['last_id'];
        
            if ($orderId) {
                $detailSql = "INSERT INTO order_detail (order_id, product_id, quantity, price, sale) VALUES ";
                $valueArr = [];
        
                foreach ($items as $item) {
                    $valueArr[] = sprintf("(%d, %d, %d, %.2f, %.2f)",
                        $orderId,
                        (int)$item['product_id'],
                        (int)$item['quantity'],
                        (float)$item['price'],
                        (float)$item['sale']
                    );
                    // Giảm số lượng tồn kho
                    $this->decreaseProductStock($item['product_id'], $item['quantity']);
                }
        
                $detailSql .= implode(", ", $valueArr);
                $this->db->insert($detailSql);
            }
            
            return $orderId;
        }
        
        public function createNewOrder($usid) {
            $id = mysqli_real_escape_string($this->db->link, $usid);
            $cartItems = $this->cart->getCartByUserId($id);
            $grandtotal = 0;
            $items = [];
            while($item = $cartItems->fetch_assoc()) {
                // Kiểm tra số lượng tồn kho
                $currentStock = $this->getProductStock($item['product_id']);
                if ($currentStock < $item['quantity']) {
                    throw new Exception("Sản phẩm {$item['pdname']} chỉ còn {$currentStock} sản phẩm");
                }

                $productTotal = $item['price'] * $item['quantity'] * (1 - $item['sale']);
                $grandtotal += $productTotal;
                $items[] = $item;
            }

            $order_insert = "INSERT INTO orders (user_id, total_price) VALUES ('$id', '$grandtotal')";
            $this->db->insert($order_insert);

            // Lấy ID đơn hàng vừa tạo bằng cách query lại
            $getLastIdQuery = "SELECT LAST_INSERT_ID() as last_id";
            $result = $this->db->select($getLastIdQuery);
            $row = $result->fetch_assoc();
            $orderId = $row['last_id'];

            if($orderId) {
                $detailSql = "INSERT INTO order_detail (order_id, product_id, quantity, price, sale) VALUES ";
                $valueArr = [];
        
                foreach ($items as $item) {
                    $valueArr[] = sprintf("(%d, %d, %d, %.2f, %.2f)",
                        $orderId,
                        (int)$item['product_id'],
                        (int)$item['quantity'],
                        (float)$item['price'],
                        (float)$item['sale']
                    );
                    //Giảm số lượng tồn kho
                    $this->decreaseProductStock($item['product_id'], $item['quantity']);
                }
        
                $detailSql .= implode(", ", $valueArr);
                $this->db->insert($detailSql);
            }
            return $orderId;
        }
        // Hàm lấy số lượng tồn kho
        private function getProductStock($productId) {
            $productId = (int)$productId; // Ép kiểu bảo mật
            $query = "SELECT quantity FROM product WHERE id = $productId";
            $result = $this->db->select($query);
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return (int)$row['quantity'];
            }
            return 0; // Trả về 0 nếu không tìm thấy sản phẩm
        }

        // Hàm giảm số lượng tồn kho
        private function decreaseProductStock($productId, $quantity) {
            // Ép kiểu để tránh SQL injection
            $productId = (int)$productId;
            $quantity = (int)$quantity;
            
            $query = "UPDATE product SET quantity = GREATEST(0, quantity - $quantity), sold_quantity = (sold_quantity + $quantity) WHERE id = $productId";
            error_log("Executing SQL: " . $query); // Ghi log câu SQL
            return $this->db->update($query);
        }

        public function getCustomerOrder($usId) {
            
            $query = "SELECT o.id, o.order_date, o.total_price, o.status, 
                     od.product_id, od.quantity, od.price, od.sale,
                     p.name AS product_name
              FROM orders o
              JOIN order_detail od ON o.id = od.order_id
              JOIN product p ON od.product_id = p.id
              WHERE o.user_id = '$usId'
              ORDER BY o.order_date DESC";

            $result = $this->db->select($query);
            // Kiểm tra nếu không có kết quả
            if (!$result || $result->num_rows === 0) {
                return [];
            }
            $orders = [];
            while($row = $result->fetch_assoc()) {
                $orderId = $row['id'];
                if(!isset($orders[$orderId])) {
                    $orders[$orderId] = [
                        'order_info' => [
                            'id' => $row['id'],
                            'date' => $row['order_date'],
                            'total' => $row['total_price'],
                            'status' => $row['status']
                        ],
                        'products' => []
                    ];
                }
                $orders[$orderId]['products'][] = [
                    'product_id' => $row['product_id'],
                    'name' => $row['product_name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'sale' => $row['sale']
                ];
            }
            return $orders;
        }
        // Lấy danh sách đơn hàng tổng quan
        public function getOrdersList($limit = 5, $offset = 0) {
            $query = "SELECT o.id, o.total_price, o.status, o.order_date, 
                            u.username AS customer_name
                    FROM orders o
                    JOIN customer u ON o.user_id = u.id
                    ORDER BY o.order_date DESC
                    LIMIT $limit OFFSET $offset";
            
            $result = $this->db->select($query);
            $orders = [];
            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            return $orders;
        }
        public function countOrders() {
            $query = "SELECT COUNT(*) as total FROM orders";
            $result = $this->db->select($query);
            return $result->fetch_assoc()['total'];
        }
        // Lấy chi tiết đơn hàng
        public function getOrderDetails($orderId) {
            $query = "SELECT o.*, u.*, od.*, p.pdname, p.image
                    FROM orders o
                    JOIN customer u ON o.user_id = u.id
                    JOIN order_detail od ON o.id = od.order_id
                    JOIN products p ON od.product_id = p.id
                    WHERE o.id = " . (int)$orderId;
            
            return $this->db->select($query);
        }

        public function deleteOrderById($id) {
            $query = "DELETE FROM orders WHERE id = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = '<div class="alert alert-success" role="alert">Xóa thành công!</div>';
                 return $alert;
            }else {
                $alert = '<div class="alert alert-success" role="alert">Xóa thất bại!</div>';
                return $alert;
            }
        }

        public function getMonthlyRevenue($year = null) {
            if (!$year) {
                $year = date('Y'); // Mặc định năm hiện tại
            }
            
            $query = "SELECT 
                        MONTH(order_date) AS month,
                        SUM(total_price) AS revenue
                      FROM 
                        orders
                      WHERE 
                        YEAR(order_date) = ?
                        AND status = 'completed'
                      GROUP BY 
                        MONTH(order_date)
                      ORDER BY 
                        month ASC";
            
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("i", $year);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $revenueData = [];
            while ($row = $result->fetch_assoc()) {
                $revenueData[$row['month']] = $row['revenue'];
            }
            
            // Đảm bảo có đủ 12 tháng
            $fullYearData = [];
            for ($m = 1; $m <= 12; $m++) {
                $fullYearData[$m] = isset($revenueData[$m]) ? $revenueData[$m] : 0;
            }
            
            return $fullYearData;
        }

        public function getAnnualRevenue($year = null) {
            if (!$year) {
                $year = date('Y');
            }
            
            $query = "SELECT SUM(total_price) AS total_revenue 
                      FROM orders 
                      WHERE YEAR(order_date) = ? 
                      AND status = 'completed'";
            
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("i", $year);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc()['total_revenue'] ?? 0;
        }
        
        
    }
?>