<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');


?>
<?php 

    class user {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        public function loginUser($data) {
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $password = mysqli_real_escape_string($this->db->link,  $data['password']);

            if(empty($email) || empty($password)) {
                $alert = '<div class="alert alert-danger" role="alert">Không được để trống!</div>';
                return $alert;
            }else {
                $query = "SELECT * FROM customer WHERE email = '$email' AND password = '$password' AND role = 'user' LIMIT 1";
                $result = $this->db->select($query);
                if($result != false) {
                    $value = $result->fetch_assoc();
                    Session::set('customer_login', true);
                    Session::set('customer_id', $value['id']);
                    Session::set('customer_name', $value['username']);
                    Session::set('customer_fullname', $value['fullname']);
                    header("Location: index.php");
                }else {
                    $alert = '<div class="alert alert-danger" role="alert">Email hoặc password không chính xác!</div>';
                    return $alert;
                }
            }
        }

        public function insertCustomer($data) {
            $username = mysqli_real_escape_string($this->db->link, $data['username']);
            $email = mysqli_real_escape_string($this->db->link, $data['reg_email']);
            $password = mysqli_real_escape_string($this->db->link, $data['reg_password']);
            $fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            
            $check_email = "SELECT * FROM customer WHERE email = '$email' LIMIT 1";
            $result_check = $this->db->select($check_email);
            if($result_check) {
                $alert = '<div class="alert alert-danger" role="alert">Email đã tồn tại</div>';
                return $alert;
            }else {
                $query = "INSERT INTO customer(username, password, email, fullname, phone) VALUES ('$username', '$password', '$email', '$fullname', '$phone')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = '<div class="alert alert-success" role="alert">Đăng ký thành công</div>';
                    return $alert;
                }
                else {
                    $alert = '<div class="alert alert-danger" role="alert">Đăng ký thất bại! Hãy thử lại</div>';
                    return $alert;
                }
            }


        }
        public function getUserById($id) {
            $idus = mysqli_real_escape_string($this->db->link, $id);
            $query = "SELECT * FROM customer WHERE id = '$idus' LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }

        public function updateUserById($data, $id) {
            $id = mysqli_real_escape_string($this->db->link, $id);
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $password = mysqli_real_escape_string($this->db->link, $data['password']);
            $username = mysqli_real_escape_string($this->db->link, $data['username']);
            $fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $address = mysqli_real_escape_string($this->db->link, $data['address']);


            if(empty($email) || empty($password) || empty($username) || empty($phone) || empty($address) ) {
                $alert ='<div class="alert alert-danger" role="alert">Các trường không được bỏ trống!</div>';
                return $alert;
            }
            else {
                $query = "UPDATE customer SET username = '$username', password = '$password', email = '$email', fullname = '$fullname', phone = '$phone', address = '$address' WHERE id = '$id'";
                $result = $this->db->update($query);
                if($result) {
                    $alert = '<div class="alert alert-success" role="alert">Thay đổi thông tin thành công!</div>';
                    return $alert;
                }else {
                    $alert = '<div class="alert alert-danger" role="alert">Thay đổi thất bại! Hãy thử lại</div>';
                    return $alert;
                }
            }
        }

        public function getUser() {
            $query = "SELECT * FROM customer ";
            $result = $this->db->select($query);
            return $result;
        }

        public function deleteUserById($id) {
            $query = "DELETE FROM customer WHERE id = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = '<div class="alert alert-success" role="alert">Xóa thành công!</div>';
                 return $alert;
            }else {
                $alert = '<div class="alert alert-success" role="alert">Xóa thất bại!</div>';
                return $alert;
            }
        }

        
    }



?>