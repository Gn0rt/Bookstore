<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');

?>
<?php 

    class ordera {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
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
        public function getOrdersList($page = 1, $limit = 20) {
            $offset = ($page - 1) * $limit;
            $query = "SELECT o.id, o.total_price, o.status, o.order_date, 
                            u.username AS customer_name
                    FROM orders o
                    JOIN customer u ON o.user_id = u.id
                    ORDER BY o.order_date DESC
                    LIMIT $limit OFFSET $offset";
            
            return $this->db->select($query);
        }
        // Lấy chi tiết đơn hàng
        public function getOrderDetails($orderId) {
            $query = "SELECT o.*, u.*, od.*, p.name
                    FROM orders o
                    JOIN customer u ON o.user_id = u.id
                    JOIN order_detail od ON o.id = od.order_id
                    JOIN product p ON od.product_id = p.id
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
        public function updateOrderById($id, $status) { 
            $newStatus = mysqli_real_escape_string($this->db->link, $status);
            // Cập nhật trạng thái
            $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE id = $id";
            $result = $this->db->update($updateQuery);
            if ($result) {
                $alert =  '<div class="alert alert-success">Cập nhật trạng thái đơn hàng thành công!</div>';
                return $alert;
            } else {
                $alert = '<div class="alert alert-danger">Cập nhật trạng thái đơn hàng thất bại!</div>';
                return $alert;
            }
        }
    }
?>