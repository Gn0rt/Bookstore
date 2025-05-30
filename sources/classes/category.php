<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');
?>
<?php 

    class category {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        public function insertCategory($catName, $descName) {
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $descName = mysqli_real_escape_string($this->db->link, $descName);
            

            if(empty($catName)) {
                $alert = "Bạn cần điền danh mục mới có thể thêm!";
                return $alert;
            }else {
                $query = "INSERT INTO category(name, description) VALUES ('$catName', '$descName')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "Thêm danh mục thành công!";
                    return $alert;
                }else {
                    $alert = "Thêm danh mục thất bại!";
                    return $alert;
                }

            }
        }
        public function selectCategory() {
            $query = "SELECT * FROM category ORDER BY id asc";
            $result = $this->db->select($query);
            return $result;
        }

        public function getCatById($id) {
            $query = "SELECT * FROM category WHERE id = '$id'";
            $result = $this->db->insert($query);
            return $result;
        }
        public function updateCatById($catName, $descName, $id) {
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $descName = mysqli_real_escape_string($this->db->link, $descName);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if(empty($catName)) {
                $alert = "Bạn không được để trống!";
                return $alert;
            }else {
                $query = "UPDATE category SET name = '$catName', description = '$descName' WHERE id = '$id'";
                $result = $this->db->update($query);
                if($result) {
                    $alert = "Cập nhật thành công!";
                    return $alert;
                }else {
                    $alert = "Cập nhật thất bại!";
                    return $alert;
                }
                
            }
            
        }

        public function deleteCatById($id) {
            $query = "DELETE FROM category WHERE id = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "Xóa thành công!";
                 return $alert;
            }else {
                $alert = "Xóa thất bại!";
                return $alert;
            }
            
        }
    }



?>