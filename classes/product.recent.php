<?php
    //CONNECT TO DATABASE
    require_once 'classes/database.php';

    //CREATE CLASS NEWS
    Class Product{
        
        //attributes
        protected $db;

        function __construct() {
            $this->db = new Database();
        }

        // Fetches the most recent records from the "product" table and returns them in descending order by the creation date.
        // This function retrieves a specified number of recent product records from the database.
        // It prepares and executes a SQL select statement with a limit on the number of records, ordered by the creation date in descending order.
        public function fetchRecentRecords($limit) {

            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT id, seller_id, product_name, product_display, product_description, product_category, stocks, price, created_at, updated_at FROM product ORDER BY created_at DESC LIMIT :limit;');
            $select_stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $select_stmt->execute();
            
            $data = $select_stmt->fetchAll();

            return $data;
        }
    }
?>
    