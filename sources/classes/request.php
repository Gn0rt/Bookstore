<?php 
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');


?>

<?php 
    class request {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }


        public function createRestockRequest($product_id, $quantity) {
            $query = "INSERT INTO restock_request (product_id, quantity) VALUES (?, ?)";
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("ii", $product_id, $quantity);
            return $stmt->execute();
        }
 
        
        
        public function getRestockRequests() {
            $query = "SELECT * FROM restock_request ORDER BY request_date DESC";
            return $this->db->select($query);
        }
    }

?>