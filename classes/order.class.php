<?php 
require_once 'database.php';

Class Order{

    public $id;
    public $product_id;
    public $user_acc_data_id;
    public $quantity;
    public $total;
    public $product_display;
    public $product_name;
    public $price;
    public $order_total;
    public $status;
    public $tracking_number;
    public $uid;
    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }





    // Function to fetch saleable products based on quantity ordered and status "Completed"
    public function getSaleableProducts() {
        // SQL query to select saleable products based on quantity threshold and status
        $query = "SELECT product_id, product_name, product_display, price, product_category
            FROM (
                SELECT product_id, SUM(quantity) as total_quantity
                FROM `order`
                WHERE status = 'Completed'
                GROUP BY product_id
                HAVING SUM(quantity) >= 5
            ) as saleable
            JOIN `product` p ON saleable.product_id = id
        ";
        
        // Prepare and execute the query
        $stmt = $this->db->connect()->prepare($query);
        $stmt->execute();
        
        // Fetch all saleable products as an associative array
        $saleableProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $saleableProducts; // Return the array of saleable products with attributes
    }


    public function complete_order($order_id) {
        $query = "UPDATE `order` SET status='Completed' WHERE id=:order_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT); // Assuming order_id is an integer
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle exceptions if necessary
            echo "Failed to update order status: " . $e->getMessage();
            return false;
        }
    }


    public function addTrackingNumber($order_id, $tracking_number) {
        // Update order status to "Intransit" and store tracking number
        $query = "UPDATE `order` SET status='Intransit', tracking_number=:tracking_number WHERE id=:order_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle exceptions if necessary
            echo "Failed to add tracking number: " . $e->getMessage();
            return false;
        }
    }

    public function confirm_order($order_id) {
        $query = "UPDATE `order` SET status='Confirmed' WHERE id=:order_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT); // Assuming order_id is an integer
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle exceptions if necessary
            echo "Failed to update order status: " . $e->getMessage();
            return false;
        }
    }

    //
    public function fetchPendingOrder($seller_id) {
        $query = "SELECT * FROM `order` WHERE seller_id = :seller_id AND status = 'Pending'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //
    public function fetchConfirmedOrder($seller_id) {
        $query = "SELECT * FROM `order` WHERE seller_id = :seller_id AND status = 'Confirmed'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //
    public function fetchIntransitOrder($seller_id) {
        $query = "SELECT * FROM `order` WHERE seller_id = :seller_id AND status = 'Intransit'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //
    public function fetchCancelledOrder($seller_id) {
        $query = "SELECT * FROM `order` WHERE seller_id = :seller_id AND status = 'Cancelled'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //
    public function fetchCompletedOrder($seller_id) {
        $query = "SELECT * FROM `order` WHERE seller_id = :seller_id AND status = 'Completed'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
     // Prepare the query to select All orders for a specific user
    public function getAllOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Prepare the query to select orders with 'Pending' status for a specific user
    public function getPendingOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id AND status = 'Pending'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Prepare the query to select orders with 'Pending' status for a specific user
    public function getConfirmedOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id AND status = 'Confirmed'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Prepare the query to select orders with 'Pending' status for a specific user
    public function getIntransitOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id AND status = 'Intransit'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Prepare the query to select orders with 'Pending' status for a specific user
    public function getCancelledOrders($user_id) {

        $query = "SELECT * FROM `order` WHERE user_id = :user_id AND status = 'Cancelled'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Prepare the query to select orders with 'Pending' status for a specific user
    public function getCompletedOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE user_id = :user_id AND status = 'Completed'";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Assuming user_id is an integer
        $stmt->execute();
    
        // Fetch all rows as an associative array
        $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $pendingOrders; // Return the array of pending orders, empty array if no pending orders
    }

    // Adds a new transaction to the "order" table
    // This function inserts a new order record into the database using the provided data array.
    // It prepares and executes a SQL insert statement with the product ID, user account data ID, quantity, order total, and status.
    public function addTransaction($data) {
        $query = 'INSERT INTO `order` (product_id, user_acc_data_id, quantity, order_total, status) VALUES(:product_id, :user_acc_data_id, :quantity, :order_total, :status)';
        $stmt = $this->db->getConnection()->prepare($query);

        $stmt->bindValue(':product_id', $data['product_id']);
        $stmt->bindValue(':user_acc_data_id', $data['user_acc_data_id']);
        $stmt->bindValue(':quantity', $data['quantity']);
        $stmt->bindValue(':order_total', $data['order_total']);
        $stmt->bindValue(':status', $data['status']);

        return $stmt->execute();
    }
    

    // Retrieves the product ID based on the product name
    // This static function accepts a product name as a parameter and returns the corresponding product ID from the database.
    // It prepares and executes a SQL select statement, binds the result to the product ID variable, fetches the result, and returns it.
    public static function getProductIdByName($product_name) {
        $query = "SELECT id FROM products WHERE name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $product_name);
        $stmt->execute();
        $stmt->bind_result($product_id);
        $stmt->fetch();
        $stmt->close();
        return $product_id;
    }


    // Inserts a new order into the "order" table
    // This function inserts a new order record into the database using the provided order data array.
    // It prepares and executes a SQL insert statement with the product ID, user account data ID, quantity, order total, and status.
    public function insertOrder($order_data) {
        $query = "INSERT INTO `order` (product_id, user_acc_data_id, quantity, order_total, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiids", 
            $order_data['product_id'], 
            $order_data['user_acc_data_id'], 
            $order_data['quantity'], 
            $order_data['order_total'], 
            $order_data['status']
        );
        $stmt->execute();
        $stmt->close();
    }
    

    // Fetches all items in the cart for a specific event
    // This function retrieves all items in the cart associated with a specific event ID.
    // It prepares and executes a SQL select statement, binds the event ID parameter, fetches all results, and returns them.
    function fetchCartItems() {
        $sql = "SELECT * FROM `order` INNER JOIN event ON order.event_id = event.id WHERE order.event_id = :event_id;";
        $query = $this->db->connect()->prepare($sql);   
        
        $query->bindParam(':event_id', $this->event_id);
    
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }


    // Fetches all cart records for a specific user
    // This function retrieves all cart records associated with a specific user ID.
    // It prepares and executes a SQL select statement, binds the user ID parameter, fetches all results as associative arrays, and returns them.
    public function fetchAllRecords($user_id) {
        $data = null;
    
        try {
            // Prepare the SQL query
            $select_stmt = $this->db->connect()->prepare('SELECT * FROM cart WHERE user_id = :user_id');
            
            // Bind the parameter
            $select_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            // Execute the query
            $select_stmt->execute();
            
            // Fetch all records as associative arrays
            $data = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
        }
    
        return $data;
    }

    // Deletes a specific item from the cart for a specific user
    // This function deletes a cart item identified by item ID for a specific user identified by user ID.
    // It prepares and executes a SQL delete statement, binds the item ID and user ID parameters, and executes the statement.
    public function deleteCartItem($item_id, $user_id) {
        try {
            $delete_stmt = $this->db->connect()->prepare('DELETE FROM cart WHERE id = :item_id AND user_id = :user_id');
            $delete_stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            return $delete_stmt->execute();
        } catch(PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // New method to fetch the total number of items in the cart for a specific user
    // This function retrieves and returns the total count of items in the cart for the given user (identified by user_id).
    // It prepares and executes a SQL query to count the number of items in the cart where the user_id matches the provided parameter.
    public function fetchTotalItems($user_id) {
        $totalItems = 0;

        try {
            // Prepare the SQL query to count total items
            $count_stmt = $this->db->connect()->prepare('SELECT COUNT(*) as total_items FROM cart WHERE user_id = :user_id');
            
            // Bind the parameter
            $count_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            // Execute the query
            $count_stmt->execute();
            
            // Fetch the result
            $result = $count_stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $totalItems = $result['total_items'];
            }
            
        } catch(PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
        }

        return $totalItems;
    }
}

?>

