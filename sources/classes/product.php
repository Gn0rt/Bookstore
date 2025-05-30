<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
?>
<?php 

    class product {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        //public function insertProduct($data, $file) {
        //     $nameProduct = mysqli_real_escape_string($this->db->link, $data['nameProduct']);
        //     $category = mysqli_real_escape_string($this->db->link, $data['category']);
        //     $priceProduct = mysqli_real_escape_string($this->db->link, $data['priceProduct']);
        //     $sale = mysqli_real_escape_string($this->db->link, $data['sale']);
        //     $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
        //     $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
        //    // kiem tra hinh anh và lấy hình ảnh cho vào folder upload 
        //     $permited = array('jpg', 'jpeg', 'png', 'gif');
        //     $file_name = $_FILES['imageProduct']['name'];
        //     $file_size = $_FILES['imageProduct']['size'];
        //     $file_temp = $_FILES['imageProduct']['tmp_name'];

        //     $div = explode('.', $file_name);
        //     $file_ext = strtolower(end($div));
        //     $unique_image = substr(md5(time()), 0, 10). '.' .$file_ext;
        //     $uploaded_image = "uploads/" . $unique_image;
            
        //     if($nameProduct == "" || $category == "" || $priceProduct == "" || $sale == "" || 
        //         $quantity == "" || $file_name == "") {

        //         $alert = "Các trường không được để trống!";
        //         return $alert;
        //     }else {
        //         move_uploaded_file($file_temp, $uploaded_image);
        //         $query = "INSERT INTO product(name, category_id, price, sale, quantity, description, image) VALUES ('$nameProduct', '$category', '$priceProduct', '$sale', '$quantity', '$desc', '$unique_image')";
        //         $result = $this->db->insert($query);
        //         if($result) {
        //             $alert = "Thêm sản phẩm thành công!";
        //             return $alert;
        //         }else {
        //             $alert = "Thêm sản phẩm thất bại!";
        //             return $alert;
        //         }
        //     }
    
        //}
        

        public function insertProduct($data, $file) {
            $nameProduct = mysqli_real_escape_string($this->db->link, $data['nameProduct']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $priceProduct = mysqli_real_escape_string($this->db->link, $data['priceProduct']);
            $sale = mysqli_real_escape_string($this->db->link, $data['sale']);
            $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
            $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
            $type = mysqli_real_escape_string($this->db->link, $data['productType']);
            
            // Kiểm tra và xử lý hình ảnh
            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['imageProduct']['name'];
            $file_size = $_FILES['imageProduct']['size'];
            $file_temp = $_FILES['imageProduct']['tmp_name'];
        
            // Xác định thư mục đích theo category
            $category_mapping = [
                '1' => 'book',
                '2' => 'toy',
                '3' => 'school'
            ];
            
            $category_folder = $category_mapping[$category] ?? 'other';
            $target_dir = "../images/{$category_folder}/";
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
        
            // Tạo tên file unique
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10). '.' .$file_ext;
            $uploaded_image = $target_dir . $unique_image;  // Đường dẫn đầy đủ
            
            // Validate input
            if(empty($nameProduct) || empty($category) || empty($priceProduct) || 
               empty($sale) || empty($quantity) || empty($file_name)) {
                return "Các trường không được để trống!";
            }
            
            // Kiểm tra định dạng file
            if(!in_array($file_ext, $permited)) {
                return "Chỉ chấp nhận ảnh định dạng: " . implode(', ', $permited);
            }
            
            // Upload ảnh và lưu database
            if(move_uploaded_file($file_temp, $uploaded_image)) {
                $query = "INSERT INTO product(name, category_id, price, sale, quantity, description, image, type) 
                         VALUES ('$nameProduct', '$category', '$priceProduct', '$sale', '$quantity', '$desc', '$uploaded_image', '$type')";
                
                $result = $this->db->insert($query);
                if($result) {
                    return "Thêm sản phẩm thành công!";
                } else {
                    // Xóa file đã upload nếu insert db thất bại
                    unlink($uploaded_image);
                    return "Thêm sản phẩm thất bại!";
                }
            } else {
                return "Upload ảnh thất bại!";
            }
        }
        
        public function selectProduct() {
            $query = "SELECT * FROM product ORDER BY id asc";
            $result = $this->db->select($query);
            return $result;
        }
        public function selectProductCat($limit = 10, $offset = 0) {
            $query = "
                SELECT 
                    p.id AS pd_id,
                    p.name AS pd_name,
                    p.price,
                    p.sale,
                    p.quantity,
                    p.stock_status,
                    p.description,
                    p.image,
                    p.created_at,
                    p.type,
                    c.name AS cat_name
                    
                FROM 
                    product p
                INNER JOIN 
                    category c
                ON 
                    p.category_id = c.id
                ORDER BY
                    p.id ASC
                LIMIT $limit OFFSET $offset
                
            ";
            $result = $this->db->select($query);
            return $result;
        }

        public function selectProductCat1($limit = 10, $offset = 0, $searchTerm='') {
            $query = "
                SELECT 
                    p.id AS pd_id,
                    p.name AS pd_name,
                    p.price,
                    p.sale,
                    p.quantity,
                    p.stock_status,
                    p.description,
                    p.image,
                    p.created_at,
                    p.type,
                    c.name AS cat_name
                    
                FROM 
                    product p
                INNER JOIN 
                    category c
                ON 
                    p.category_id = c.id
            ";
            if(!empty($searchTerm)) {
                $searchTerm = mysqli_real_escape_string($this->db->link, $searchTerm);
                $query .= " WHERE p.name LIKE '%$searchTerm%' OR c.name LIKE '%$searchTerm%' ";
            }
            $query .= "
                ORDER BY
                    p.id ASC
                LIMIT $limit OFFSET $offset
            ";
            $result = $this->db->select($query);
            return $result;
        }
        public function selectProductType($limit = 10, $offset = 0, $type ='') {
            $query = "
                SELECT 
                    p.id AS pd_id,
                    p.name AS pd_name,
                    p.price,
                    p.sale,
                    p.quantity,
                    p.stock_status,
                    p.description,
                    p.image,
                    p.created_at,
                    p.type,
                    c.name AS cat_name
                    
                FROM 
                    product p
                INNER JOIN 
                    category c
                ON 
                    p.category_id = c.id
            ";
            // Lọc theo thể loại nếu có
            if(!empty($type)) {
                $type = mysqli_real_escape_string($this->db->link, $type);
                $query .= " AND p.type = '$type'";
            }
            $query .= "
                ORDER BY
                    p.id ASC
                LIMIT $limit OFFSET $offset
            ";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLowStockProducts($threshold = 7) {
            $query = "SELECT id, name, quantity FROM product WHERE quantity <= ? ORDER BY quantity ASC";
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("i", $threshold);
            $stmt->execute();
            return $stmt->get_result();
        }
        public function getProductById($id) {
            $query = "SELECT * FROM product WHERE id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
        // function updateProductById($data, $file, $id) {
        //     $nameProduct = mysqli_real_escape_string($this->db->link, $data['productName']);
        //     $category = mysqli_real_escape_string($this->db->link, $data['productCat']);
        //     $priceProduct = mysqli_real_escape_string($this->db->link, $data['productPrice']);
        //     $sale = mysqli_real_escape_string($this->db->link, $data['productSale']);
        //     $quantity = mysqli_real_escape_string($this->db->link, $data['productQuantity']);
        //     $status = mysqli_real_escape_string($this->db->link, $data['productStatus']);
        //     $desc = mysqli_real_escape_string($this->db->link, $data['productDesc']);
        //     $type = mysqli_real_escape_string($this->db->link, $data['productType']);
        //    // kiem tra hinh anh và lấy hình ảnh cho vào folder upload 
        //     $permited = array('jpg', 'jpeg', 'png', 'gif');
        //     $file_name = $_FILES['productImg']['name'];
        //     $file_size = $_FILES['productImg']['size'];
        //     //file tạm
        //     $file_temp = $_FILES['productImg']['tmp_name'];

        //     $div = explode('.', $file_name);
        //     $file_ext = strtolower(end($div));
        //     $unique_image = substr(md5(time()), 0, 10). '.' .$file_ext;
        //     $uploaded_image = "uploads/" . $unique_image;
        //     $max_size_bytes = 5 * 1024 * 1024;
        //     if($nameProduct == "" || $category == "" || $priceProduct == "" || $sale == "" || 
        //         $quantity == "") {

        //         $alert ='<div class="alert alert-danger" role="alert">Các trường không được bỏ trống!</div>';
        //         return $alert;
        //     }else {
        //         if(!empty($file_name)) {
        //             //nếu người dùng chọn ảnh
        //             if($file_size > $max_size_bytes) {
        //                 $alert =  '<div class="alert alert-danger" role="alert">Dung lượng ảnh phải < 5MB</div>';
        //                 return $alert;
        //             }else if (in_array($file_ext, $permited) === false){
        //                 $alert = '<div class="alert alert-danger" role="alert">You can upload only:- '.implode(', ', $permited).' </div>';
        //                 return $alert;
        //             }
        //             move_uploaded_file($file_temp, $uploaded_image);

        //             $query = "UPDATE product SET
        //             name = '$nameProduct',
        //             category_id = '$category',
        //             price = '$priceProduct',
        //             sale = '$sale',
        //             quantity = '$quantity',
        //             stock_status = '$status',
        //             description = '$desc',
        //             image = '$unique_image'

        //             WHERE id = '$id'
        //             ";
        //         }else {
        //             //không chọn ảnh
        //             $query = "UPDATE product SET
        //             name = '$nameProduct',
        //             category_id = '$category',
        //             price = '$priceProduct',
        //             sale = '$sale',
        //             quantity = '$quantity',
        //             stock_status = '$status',
        //             description = '$desc'
        //             WHERE id = '$id'
        //             ";
        //         } 
                
        //     }
        //     $result = $this->db->insert($query);
        //     if($result) {
        //         $alert = '<div class="alert alert-success" role="alert">Sửa sản phẩm thành công!</div>';
        //         return $alert;
        //     }else {
        //         $alert = '<div class="alert alert-danger" role="alert">Thêm sp thất bại!</div>';
        //         return $alert;
        //     }
            
        //}


        public function updateProductById($data, $file, $id) {
            // Escape và validate dữ liệu
            $id = (int)$id;
            $nameProduct = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = (int)$data['productCat'];
            $priceProduct = (float)$data['productPrice'];
            $sale = (float)$data['productSale'];
            $quantity = (int)$data['productQuantity'];
            $status = mysqli_real_escape_string($this->db->link, $data['productStatus']);
            $desc = mysqli_real_escape_string($this->db->link, $data['productDesc']);
        
            // Kiểm tra và xử lý hình ảnh
            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['productImg']['name'];
            $file_size = $_FILES['productImg']['size'];
            $file_temp = $_FILES['productImg']['tmp_name'];

            // Xác định thư mục đích theo category
            $category_mapping = [
                '1' => 'book',
                '2' => 'toy',
                '3' => 'school'
            ];
            $category_folder = $category_mapping[$category] ?? 'other';
            $target_dir = "../images/{$category_folder}/";
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Tạo tên file unique
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = $target_dir . $unique_image; // Đường dẫn đầy đủ
            
            // Validate input
            if(empty($nameProduct) || empty($category) || empty($priceProduct) || 
            empty($sale) || empty($quantity)) {
                return '<div class="alert alert-danger" role="alert">Các trường không được để trống!</div>';
            }
            
            // Nếu có ảnh mới được chọn
            if (!empty($file_name)) {
                // Kiểm tra dung lượng và định dạng file
                if ($file_size > 5 * 1024 * 1024) { // 5MB
                    return '<div class="alert alert-danger" role="alert">Dung lượng ảnh phải < 5MB</div>';
                } elseif (!in_array($file_ext, $permited)) {
                    return '<div class="alert alert-danger" role="alert">Chỉ chấp nhận ảnh định dạng: ' . implode(', ', $permited) . '</div>';
                }
                
                // Upload ảnh
                move_uploaded_file($file_temp, $uploaded_image);
                
                // Cập nhật thông tin sản phẩm (bao gồm đường dẫn ảnh mới)
                $query = "UPDATE product SET
                        name = '$nameProduct',
                        category_id = '$category',
                        price = '$priceProduct',
                        sale = '$sale',
                        quantity = '$quantity',
                        stock_status = '$status',
                        description = '$desc',
                        image = '$uploaded_image'
                        WHERE id = '$id'";
            } else {
                // Không chọn ảnh mới, giữ nguyên ảnh cũ
                $query = "UPDATE product SET
                        name = '$nameProduct',
                        category_id = '$category',
                        price = '$priceProduct',
                        sale = '$sale',
                        quantity = '$quantity',
                        stock_status = '$status',
                        description = '$desc'
                        WHERE id = '$id'";
            }

            // Thực hiện cập nhật
            $result = $this->db->update($query);
            if ($result) {
                return '<div class="alert alert-success" role="alert">Cập nhật sản phẩm thành công!</div>';
            } else {
                // Xóa file đã upload nếu insert db thất bại
                if (file_exists($uploaded_image)) {
                    unlink($uploaded_image);
                }
                return '<div class="alert alert-danger" role="alert">Cập nhật sản phẩm thất bại!</div>';
            }
        }

        public function selectCat() {
            $query = "SELECT id, name FROM category";
            $result = $this->db->select($query);
            return $result;
        }

        public function deleteProductById($id) {
            $query = "DELETE FROM product WHERE id = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = '<div class="alert alert-success" role="alert">Xóa sản phẩm thành công!</div>';
                 return $alert;
            }else {
                $alert = '<div class="alert alert-danger" role="alert">Xóa sản phẩm thất bại!</div>';
                return $alert;
            }
            
        }
        public function getProductByCatId($id, $searchTerm = '', $limit = 8, $offset = 0) {
            $query = "SELECT * FROM product WHERE category_id = '$id'";
            $searchTerm = mysqli_real_escape_string($this->db->link, $searchTerm); // Escape tìm kiếm
            if (!empty($searchTerm)) {
                $query .= " AND name LIKE '%$searchTerm%'"; // Thêm điều kiện tìm kiếm
            }
            $query .= " LIMIT $limit OFFSET $offset"; // Thêm phân trang
            $result = $this->db->select($query);
            return $result;
        }
        public function getProductByType($str)  {
            $query = "SELECT * FROM product WHERE type = '$str'";
            
            $result = $this->db->select($query);
            return $result;
        }
        public function getProductByImage($str)  {
            $query = "SELECT * FROM product WHERE image LIKE '../images/$str/%'";
            $result = $this->db->select($query);
            return $result;
        }
        public function countProductsByCatId($id) {
            $id = (int)$id; // Ép kiểu bảo mật
            $query = "SELECT COUNT(*) as total FROM product WHERE category_id = $id";
            $result = $this->db->select($query);
            return $result ? $result->fetch_assoc()['total'] : 0; // Trả về tổng số sản phẩm
        }
        public function countProducts() {
            $query = "SELECT COUNT(*) as total FROM product";
            $result = $this->db->select($query);
            return $result ? $result->fetch_assoc()['total'] : 0;
        }
        public function getTopSellingProductsByMonth($month, $year, $limit = 10) {
            //Ép kiểu bảo mật
            $month = (int)$month; 
            $year = (int)$year;
         
            $query = "SELECT 
                          p.id, 
                          p.name, 
                          SUM(od.quantity) AS total_quantity
                      FROM 
                          order_detail od
                      JOIN 
                          orders o ON od.order_id = o.id
                      JOIN 
                          product p ON od.product_id = p.id
                      WHERE 
                          MONTH(o.order_date) = ? AND YEAR(o.order_date) = ?
                      GROUP BY 
                          p.id, p.name
                      ORDER BY 
                          total_quantity DESC
                      LIMIT ?";
            
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("iii", $month, $year, $limit);
            $stmt->execute();
            return $stmt->get_result();
        }
        
        public function getTypeProduct() {
            $query = "SELECT DISTINCT type FROM product ORDER BY type";
            $result = $this->db->select($query);
            $types = array();
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $types[] = $row['type'];
                }
            }
            
            return $types;
        }
        
    }

?>