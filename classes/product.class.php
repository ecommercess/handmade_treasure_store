
<?php
    //CONNTECT TO DATABASE
    require_once 'database.php';
    require_once '../tools/functions.php';
    require_once '../vendor/autoload.php';
    
    //CREATE CLASS Product
    Class Product{
        
        //attributes
        protected $db;

        function __construct() {
            $this->db = new Database();
        }
		//INSERT A NEW RECORD INTO THE DATABASE "hts" & HADLE AJAX REQUEST
        public function insert() {

            $config = HTMLPurifier_Config::createDefault();
            
            $config->set('Cache.DefinitionImpl', null);
            $config->set('HTML.AllowedElements', 'strong,em');
            $config->set('HTML.AllowedAttributes', []);
            
            $purifier = new HTMLPurifier($config);   
        
            if (isset($_POST['product_name'])) {
                if (isset($_FILES['product_display']) && $_FILES['product_display']['error'] === UPLOAD_ERR_OK) {
                    // Disable the submit button to prevent multiple submissions
                    //'$("#addbtn").prop("disabled", true);';
        
                    // Sanitizing the inputs
                    $product_name = htmlentities($_POST['product_name']);
                    $product_description = htmlentities($purifier->purify($_POST['product_description']));
                    $product_category = htmlentities($_POST['product_category']);
                    $stocks = htmlentities($_POST['stocks']);
                    $price = htmlentities($_POST['price']);
                    $product_display = $_FILES['product_display']['name'];
                    $tempname_banner = $_FILES['product_display']['tmp_name'];
                    $folder = "../uploads/" . $product_display;
                    $max_file_size = 5242880; // Maximum file size in bytes (5MB)
            
                    // Check the file size before uploading the image
                    if ($_FILES['product_display']['size'] > $max_file_size) {
                        echo 'File size exceeds maximum allowed size of 5MB.';
                    } else {
                        if (move_uploaded_file($tempname_banner, $folder)) {
                            // Check if the file already exists
                            if (file_exists($folder . $product_display)) {
                                $filename_parts = pathinfo($product_display);
                                $product_display = $filename_parts['filename'] . '_' . uniqid() . '.' . $filename_parts['extension'];
                            }
                            
                            // Retrieve seller_id from the session
                            session_start();
                            if (isset($_SESSION['seller_id'])) {
                                $seller_id = $_SESSION['seller_id'];
        
                                $insert_stmt = $this->db->connect()->prepare("INSERT INTO product (product_name, product_display, product_description, product_category, stocks, price, seller_id) 
                                    VALUES (:product_name, :product_display, :product_description, :product_category, :stocks, :price, :seller_id)");
                                $insert_stmt->bindParam(':product_name', $product_name);
                                $insert_stmt->bindParam(':product_display', $product_display);
                                $insert_stmt->bindParam(':product_description', $product_description);
                                $insert_stmt->bindParam(':product_category', $product_category);
                                $insert_stmt->bindParam(':stocks', $stocks);
                                $insert_stmt->bindParam(':price', $price);
                                $insert_stmt->bindParam(':seller_id', $seller_id);
                
                                if ($insert_stmt->execute()) {
                                    echo 'Successfully saved.';
                                    // Select all emails from user_acc_data table
                                    $select_stmt = $this->db->connect()->prepare("SELECT email FROM user_acc_data");
                                    $select_stmt->execute();
                                    $emails = $select_stmt->fetchAll(PDO::FETCH_COLUMN);
        
                                    // Call sendEventInvitation function with emails parameter
                                    // sendEventInvitation($emails, $product_name, $product_display, $product_description, $stock, $price);
                                } else {
                                    echo 'Failed saving.';
                                }
                            } else {
                                echo 'Seller ID is not set. Please log in.';
                            }
                        } else {
                            echo 'Failed moving file.';
                        }
                    }
                } else {
                    echo 'No file has been uploaded.';
                }
            }
        }

        // Method to get the total quantity of a specific product ordered
        public function getTotalOrderedQuantity($product_id) {
            $query = "SELECT SUM(quantity) as total_quantity FROM `order` WHERE product_id = :product_id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT); // Assuming product_id is an integer
            $stmt->execute();
            
            // Fetch the result as an associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return the total quantity or 0 if no rows found
            return $result['total_quantity'] ?? 0;
        }

        // Method to fetch details of a specific product (for Stocks)
        public function fetchProductDetails($product_id) {
            $query = "SELECT * FROM product WHERE id = :product_id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT); // Assuming product_id is an integer
            $stmt->execute();
            
            // Fetch the result as an associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        // Fetch all products from the product table
        public function fetchAllItems() {

            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product;');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();

            return $data;
        }

        // Fetch products where product_category is "Crocheted Item"
        public function fetchCrochetedItems() {
            $data = null;
        
            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE product_category = "Crocheted Item";');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();
        
            return $data;
        }

        // Fetch products where product_category is "Satin Item"
        public function fetchSatinItems() {
            $data = null;
        
            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE product_category = "Satin Item";');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();
        
            return $data;
        }


        // Fetch products where product_category is "Key Chain"
        public function fetchKeyChainsItems() {
            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE product_category = "Key Chain";');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();

            return $data;
        }

        // Fetch products where product_category is "Phone Lace"
        public function fetchPhoneLaces() {
            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE product_category = "Phone Lace";');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();

            return $data;
        }
        
        // Fetch products where product_category is "Others"
        public function fetchOtherItems() {
            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE product_category = "Others";');
            $select_stmt->execute();
            $data = $select_stmt->fetchAll();

            return $data;
        }
                

        // Fetch all records from the "hts" database for a specific seller and handle the AJAX request.
        // This function retrieves and returns all products associated with the given seller (identified by seller_id).
        // It prepares and executes a SQL query to select all relevant product information from the database 
        // where the seller_id matches the provided parameter.
        public function fetchAllRecords($seller_id) {

            $data = null;

            $select_stmt = $this->db->connect()->prepare('SELECT id, product_name, product_display, product_description, product_category, stocks, price, created_at, updated_at FROM product WHERE seller_id = :seller_id;');
            $select_stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
            $select_stmt->execute();

            $data = $select_stmt->fetchAll();

            return $data;
        }

        // Fetch a single product record from the "hts" database by its ID and handle the AJAX request.
        // This function retrieves and returns the details of a specific product identified by the given product ID.
        // It prepares and executes a SQL query to select the product information from the database where the ID matches the provided parameter.
        public function fetchRecordById($id) {
            $select_stmt = $this->db->connect()->prepare('SELECT id, product_name, seller_id, product_display, product_description, product_category, stocks, price FROM product WHERE id = :id');
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }


        public function getTotalOrderedQty($product_id) {
            $sql = "SELECT COUNT(*) FROM `order` WHERE `product_id` = :product_id;";
            $query = $this->db->connect()->prepare($sql);
            
            $query->bindParam(':product_id', $product_id); // Corrected parameter binding

            if ($query->execute()) {
                $count = $query->fetchColumn();
                return $count;
            }
            
            return 0; // Return 0 if query fails
        }
            

		//DELETE RECORD FROM DATABASE "hts" AND HANDLE AJAX REQUEST
        public function deleteRecords($delete_id) {
            $delete_stmt = $this->db->connect()->prepare('DELETE FROM product WHERE id = :sid ');
			$delete_stmt->bindParam(':sid',$delete_id);

            if ($delete_stmt->execute()) {
				echo 'Record deleted successfully.';
			} else {
                echo 'Failed to delete the record.';
			}
        }

        //FETCH RECORD FROM DATABASE "PHSI" AND HANDLE AJAX REQUEST
        public function edit($update_id) {

            $data = null;

            $product_stmt = $this->db->connect()->prepare('SELECT * FROM product WHERE id = :sid');
			$product_stmt->bindParam(':sid', $update_id);
			
			$product_stmt->execute();
			
			$data = $product_stmt->fetch(); 
			
			return $data;
        }

        //UPDATE RECORD AND HANDLE AJAX REQUEST
        public function update($edit_id) {

            $config = HTMLPurifier_Config::createDefault();
        
            $config->set('Cache.DefinitionImpl', null);
            $config->set('HTML.AllowedElements', 'strong,em');
            $config->set('HTML.AllowedAttributes', []);
            
            $purifier = new HTMLPurifier($config);   

            if(isset($_POST['editProductName']) || isset($_POST['editProductDescription'])  || isset($_POST['editProductCategory'])  || isset($_POST['editStocks'])  || isset($_POST['editPrice']) || isset($_POST['edit_id'])) {
                if(!empty($_POST['editProductName']) || !empty($_POST['editProductDescription']) || !empty($_POST['editProductCategory']) || !empty($_POST['editStocks'])  || !empty($_POST['editPrice']) || !empty($_POST['edit_id'])) {

                    $product_name =  htmlentities($_POST['editProductName']);
                    $product_description = htmlentities($purifier->purify($_POST['editProductDescription']));
                    $product_category = isset($_POST['editProductCategory']) ? $_POST['editProductCategory'] : '';
                    if (is_array($product_category)) {
                        $product_category = implode(',', array_map('htmlentities', $product_category));
                    } else {
                        $product_category = htmlentities($product_category);
                    }  
                    $stocks =  htmlentities($_POST['editStocks']);
                    $price =  htmlentities($_POST['editPrice']);
					
                    $id = $_POST['edit_id'];
                    

                    if(isset($_FILES['product_display']) && $_FILES['product_display']['error'] === UPLOAD_ERR_OK) {
                        $product_display = $_FILES['product_display']['name'];
						$tempname_banner = $_FILES['product_display']['tmp_name'];
						$folder = "../uploads/" . $product_display;	

                        if(move_uploaded_file($tempname_banner, $folder)) {
                            $update_stmt=$this->db->connect()->prepare('UPDATE product SET product_name=:product_name, product_description=:product_description, product_display=:product_display, product_category=:product_category, stocks=:stocks, price=:price WHERE id=:id');
							$update_stmt->bindParam(':product_name', $product_name);
							$update_stmt->bindParam(':product_display', $product_display);
							$update_stmt->bindParam(':product_description', $product_description);
                            $update_stmt->bindParam(':product_category', $product_category);
                            $update_stmt->bindParam(':stocks', $stocks);
                            $update_stmt->bindParam(':price', $price);
							$update_stmt->bindParam(':id', $id);

                            //EXECUTE
                            if($update_stmt->execute()) {
                                echo 'Record updated successfully';
                            } else {
                                echo 'Failed to update the record.';
                            }
                        } 
                        else {
                            echo 'Failed moving file.';
                        }
                    }
                    else {
                        $update_stmt=$this->db->connect()->prepare('UPDATE product SET product_name=:product_name, product_description=:product_description, product_category=:product_category, stocks=:stocks, price=:price WHERE id=:id');
                        $update_stmt->bindParam(':product_name', $product_name);
                        $update_stmt->bindParam(':product_description', $product_description);
                        $update_stmt->bindParam(':product_category', $product_category);
                        $update_stmt->bindParam(':stocks', $stocks);
                        $update_stmt->bindParam(':price', $price);
                        $update_stmt->bindParam(':id', $id);	
                        
                        //EXECUTE
                        if($update_stmt->execute()) {
                            echo 'Record updated successfully.';                    
                        }
                        else {
                            echo 'Failed to update the record.';
                        }	
                    }
                } 
                else {
                    echo 'Empty form';
                }
            }

        }
    }
?>