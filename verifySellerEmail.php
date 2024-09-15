<?php

session_start();
require_once 'classes/user.class.php';


if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = new Users();
    if($user -> verify_email($token)) {
        if($user -> update_token($token)){
            $_SESSION['id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['verified'] = true;
            $_SESSION['message'] = "Your email address has been verified successfully";
            $_SESSION['type'] = 'alert-success';
            header('location: login/login-seller.php');
            exit(0);
        }
    } else {
        echo "User not found!";
    }
} else {
    echo "No token provided!";
}

?>
