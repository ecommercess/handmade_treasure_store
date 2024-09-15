<?php 
require_once 'database.php';

Class Users{
    public $id;
    public $profile_picture = 'user-icon.png';
    public $product_id;
    public $product_name;
    public $product_display;
    public $price;
    public $quantity;
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    public $email;
    public $contact_number;
    public $address;
    public $password;
    public $role = "customer";
    public $token;
    public $verified;
    public $user_id;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //FUNCTION TO CHECK IF THE EMAIL AND PASSOWRD IS IN THE USER ACC DATABASE
    function login(){
        $sql = "SELECT * FROM user_acc_data WHERE email = :email and password = :password";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':password', $this->password);
        if($query->execute()){
           $data = $query->fetch();
        }
     	return $data;
    }
   
    //INSERT A NEW USER  INTO THE DATABASE "PHSI" & HADLE AJAX REQUEST
    function signup($token){


        $sql = "INSERT INTO user_acc_data (profile_picture, firstname, middlename, lastname, suffix, email, contact_number, address, password, role, token) 
        VALUES (:profile_picture, :firstname, :middlename, :lastname, :suffix, :email, :contact_number, :address, :password, :role, :token);";

        $query=$this->db->connect()->prepare($sql);

        $query->bindParam(':profile_picture', $this->profile_picture);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':middlename', $this->middlename);
        $query->bindParam(':lastname', $this->lastname);
        $query->bindParam(':suffix', $this->suffix);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':contact_number', $this->contact_number);
        $query->bindParam(':address', $this->address);
        $query->bindParam(':password', $this->password);
        $query->bindParam(':role', $this->role);
        $query->bindValue(':token', $token);

       
        if($query->execute()){
            return "added successfully 1";
        } 
        return "error adding ";
    }
  
    function addProductToCart() {
        $sql = "INSERT INTO cart (user_id, product_id, seller_id, product_name, product_display, price, quantity, firstname, middlename, lastname, suffix, email, contact_number, address)
                VALUES (:user_id, :product_id, :seller_id, :product_name, :product_display, :price, :quantity, :firstname, :middlename, :lastname, :suffix, :email, :contact_number, :address)";
        $query = $this->db->connect()->prepare($sql);
        
    
        $query->bindParam(':user_id', $this->user_id);
        $query->bindParam(':product_id', $this->product_id);
        $query->bindParam(':seller_id', $this->seller_id);
        $query->bindParam(':product_name', $this->product_name);
        $query->bindParam(':product_display', $this->product_display);
        $query->bindParam(':price', $this->price);
        $query->bindParam(':quantity', $this->quantity);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':middlename', $this->middlename);
        $query->bindParam(':lastname', $this->lastname);
        $query->bindParam(':suffix', $this->suffix);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':contact_number', $this->contact_number);
        $query->bindParam(':address', $this->address);
    
        return $query->execute();
    }
    

    
    function verify_email(){
        $token = $_GET['token'];
        $sql = "SELECT * FROM user_acc_data WHERE token=:token LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':token', $token);
        if($query->execute()){
            $data = $query->fetchAll();
            return $data;
        }
        return false;
    }
    
    function insert_token($token) {
        $sql = "INSERT INTO user_acc_data (token) VALUES (:token)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindValue(':token', $token);
        if ($query->execute()) {
          return "added successfully";
        } else {
          return "error adding ";
        }
      }

    function update_token() {
        $token = $_GET['token'];
        $query = "UPDATE user_acc_data SET verified=1 WHERE token=:token";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':token', $token);
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Failed to update token!";
            return false;
        }
    }


    
    function fetchUser(){
        $sql = "SELECT * FROM user_acc_data;";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    function fetchUserEmails($token){
        $sql = "SELECT email FROM user_acc_data;";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll(PDO::FETCH_COLUMN);
        }
        return $data;
    }

    function getEmailsForproduct($productId, $token) {
        $sql = "SELECT email FROM rsvp
                INNER JOIN product ON product.id = rsvp.product_id
                WHERE product.id = ?";
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute([$productId])) {
            $data = $query->fetchAll(PDO::FETCH_COLUMN);
            return $data;
        } else {
            return false;
        }
    }
    
    public function fetchRecordById($id) {
        $select_stmt = $this->db->connect()->prepare('SELECT id, profile_picture, background_image, verify_one, verify_two, verify_three, verify_four, verify_five, verify_six, verify_seven, verify_eight, firstname, middlename, lastname, suffix, sex, email, contact_number, province, city, barangay, street_name, bldg_house_no, username, password, role, is_agree, status, organization, member_type FROM user_acc_data WHERE id = :id');
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function pending(){
        $sql = "SELECT * FROM user_acc_data WHERE status = 'Pending';";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    function verified(){
        $sql = "SELECT * FROM user_acc_data WHERE status = 'Verified';";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    function fetch($record_id){
        $sql = "SELECT * FROM user_acc_data WHERE id = :id;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':id', $record_id);
        if($query->execute()){
            $data = $query->fetch();
        }
        return $data;
    }

    function delete($record_id){
        $sql = "DELETE FROM user_acc_data WHERE id = :id;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':id', $record_id);
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }
    }


    function addUserToproduct($token) {
        $sql = "INSERT INTO rsvp (id, product_id, firstname, middlename, lastname, suffix, email, contact_number, province, city, barangay, street_name, bldg_house_no, member_type, join_status, token)
         VALUES (NULL, :product_id, :firstname, :middlename, :lastname, :suffix, :email, :contact_number, :province, :city, :barangay, :street_name, :bldg_house_no, :member_type, :join_status, :token);";
        $query=$this->db->connect()->prepare($sql);

        $query->bindParam(':product_id', $this->product_id);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':middlename', $this->middlename);
        $query->bindParam(':lastname', $this->lastname);
        $query->bindParam(':suffix', $this->suffix);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':contact_number', $this->contact_number);
        $query->bindParam(':province', $this->province);
        $query->bindParam(':city', $this->city);
        $query->bindParam(':barangay', $this->barangay);
        $query->bindParam(':street_name', $this->street_name);
        $query->bindParam(':bldg_house_no', $this->bldg_house_no);
        $query->bindParam(':member_type', $this->member_type);
        $query->bindParam(':join_status', $this->join_status);
        $query->bindValue(':token', $this->token);

        if($query->execute()){
            return true;
        } 
        return false;
    }    

    // function showUsername(){
    //     $sql = "SELECT * FROM user_acc_data ORDER BY username ASC;";
    //     $query=$this->db->query($sql);
    //     $result=$query->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }
    
    // function showEmail(){
    //     $sql = "SELECT * FROM user_acc_data ORDER BY email ASC;";
    //     $query=$this->db->query($sql);  
    //     $result=$query->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    // function showPassword(){
    //     $sql = "SELECT * FROM user_acc_data ORDER BY password ASC;";
    //     $query=$this->db->query($sql);
    //     $result=$query->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }


    function editUser(){
        $sql = "UPDATE user_acc_data SET profile_picture=:profile_picture, firstname=:firstname, lastname=:lastname, email=:email, middlename=:middlename, suffix=:suffix, contact_number=:contact_number, address=:address WHERE id = :id;";
        
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':profile_picture', $this->profile_picture);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':lastname', $this->lastname);
        $query->bindParam(':middlename', $this->middlename);
        $query->bindParam(':suffix', $this->suffix);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':contact_number', $this->contact_number);
        $query->bindParam(':address', $this->address);
        $query->bindParam(':id', $this->id);

        if($query->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    function changePassword(){
        $sql = "UPDATE user_acc_data SET password=:password WHERE id = :id;";
        
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':password', $this->password);
        $query->bindParam(':id', $this->id);

        if($query->execute()){
            return true;
        }
        else {
            return false;
        }
    }


}

?>

