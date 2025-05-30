<?php 
    $filepath = realpath(dirname(__FILE__));

    include($filepath.'/../lib/session.php');
    Session::checkLogin();
    include_once($filepath.'/../lib/database.php');
?>
<?php 

    class adminlogin {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        public function loginAdmin($email, $password) {
            $emailA = mysqli_real_escape_string($this->db->link, $email);
            $passwordA = mysqli_real_escape_string($this->db->link, $password);

            if(empty($email) || empty($password)) {
                $alert = "Email và mật khẩu không được để trống!";
                return $alert;
            }else {
                //$query = "SELECT * FROM customer WHERE email = '$emailA' AND password = '$passwordA' LIMIT 1";
                $query = "SELECT * FROM customer WHERE email = '$emailA' AND password = '$passwordA' AND role = 'admin' LIMIT 1";

                $result = $this->db->select($query);

                if($result != false) {
                    $value = $result->fetch_assoc();
                    Session::set('adminlogin', true);
                    Session::set('admin_id', $value['id']);
                    Session::set('admin_user', $value['username']);
                    Session::set('admin_fullname', $value['fullname']);
                    header('Location: index1.php');
                }else {
                    $alert = "Email hoặc mật khẩu không đúng!";
                    return $alert;
                }
            }
        }
    }



?>