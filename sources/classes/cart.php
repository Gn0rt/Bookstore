<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');
?>
<?php 

    class cart {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        public function addToCart($id, $quantity, $usid) {
            try {
                $quantity = mysqli_real_escape_string($this->db->link, $quantity);
                $id = mysqli_real_escape_string($this->db->link, $id);
                $sessionId = session_id();
                $sessionUser = mysqli_real_escape_string($this->db->link, $usid);
                $query = "SELECT * FROM product WHERE id = $id";
                $result = $this->db->select($query)->fetch_assoc();

                $price = $result['price'];
                $name  = $result['name'];
                $sale = $result['sale'];
                $query_insert = "INSERT INTO cart(user_id, product_id, pdname,quantity, price,sale, sid) VALUES ('$sessionUser','$id','$name', '$quantity', $price, '$sale ', '$sessionId')";
                $insert_cart = $this->db->insert($query_insert);
                if($insert_cart) {
                    header('Location: cart.php');
                    exit(); // Thêm exit() sau header để đảm bảo không có code nào chạy sau khi chuyển hướng
                }else {
                    // Rollback nếu insert thất bại
                    $this->db->link->rollback();
                    $alert = "Thêm sản phẩm thất bại!";
                    return $alert;
                }
                }catch (Exception $e) {
                    $this->db->link->rollback();
                    return "Đã có lỗi xảy ra: ". $e->getMessage();
                }
            
        }
        // public function addToCart($id, $quantity, $usid) {
        //     $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        //     $id = mysqli_real_escape_string($this->db->link, $id);
        //     $sessionId = session_id();
        //     $sessionUser = mysqli_real_escape_string($this->db->link, $usid);
        //     $query = "SELECT * FROM product WHERE id = $id";
        //     $result = $this->db->select($query)->fetch_assoc();

        //     $price = $result['price'];
        //     $name  = $result['name'];
        //     $sale = $result['sale'];
        //     $query_insert = "INSERT INTO cart(user_id, product_id, pdname,quantity, price,sale, sid) VALUES ('$sessionUser','$id','$name', '$quantity', $price, '$sale ', '$sessionId')";
        //     $insert_cart = $this->db->insert($query_insert);
        //     if($insert_cart) {
        //         header('Location: cart.php');
        //     }else {
        //         $alert = "Thêm sản phẩm thất bại!";
        //         return $alert;
        //     }
        // }

        public function getCartByUserId($usId) {
            $user = mysqli_real_escape_string($this->db->link, $usId);
            $query = "SELECT * FROM cart WHERE user_id = '$user'";
            $result = $this->db->select($query);
            return $result;
        }

        public function delAllCart(){
            $sId = session_id();
            $query = "DELETE FROM cart WHERE sid= '$sId'";
            $result = $this->db->delete($query);
            return $result;
        } 

        public function deleteCartPd($id) {
            $query = "DELETE FROM cart WHERE product_id = '$id'";
            $result = $this->db->delete($query);
            return $result;
        }
        
    }



?>