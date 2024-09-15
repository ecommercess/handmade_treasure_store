<?php 
require_once 'database.php';

Class Seller{
    public $id;
    public $profile_picture = 'user-icon.png';
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    public $email;
    public $contact_number;
    public $address;
    public $password;
    public $role = "seller";
    public $token;
    public $verified;
    public $user_id;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    // Function to check if the email and password are in the seller account database
    // This function verifies if the provided email and password match an existing record in the user account data table.
    // It prepares and executes a SQL select statement with the email and password parameters.
    // If a matching record is found, it fetches the data and returns it.
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
   
    // Function to sign up a new user and insert their information into the user account database
    // This function inserts a new user record into the user_acc_data table with the provided details and a token.
    // It prepares and executes a SQL insert statement with parameters for profile picture, first name, middle name, last name, suffix, email, contact number, address, password, role, and token.
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

    // Function to check for duplicate records in the seller account database
    // This function checks if there are any existing records in the seller_acc_data table with the same email, username, or password.
    // It prepares and executes a SQL select statement with parameters for email, username, and password.
    // If a matching record is found, it returns true indicating duplicates exist; otherwise, it returns false.
    function to_check_duplicates(){
        $sql = "SELECT * FROM seller_acc_data WHERE email=:email OR username=:username OR password=:password LIMIT 1";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':password', $this->password);
        if($query->execute()){
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if($data){
                return true; // duplicates exist
            } else {
                return false; // no duplicates found
            }
        } else {
            return false; // database query failed
        }
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
        $sql = "SELECT * FROM seller_acc_data;";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    function fetchUserEmails($token){
        $sql = "SELECT email FROM seller_acc_data;";
        $query=$this->db->connect()->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll(PDO::FETCH_COLUMN);
        }
        return $data;
    }


    function fetch($record_id){
        $sql = "SELECT * FROM seller_acc_data WHERE id = :id;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':id', $record_id);
        if($query->execute()){
            $data = $query->fetch();
        }
        return $data;
    }

}

?>

