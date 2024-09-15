<?php
    //start session
    session_start();

    //check if user is login already otherwise send to home page
    if (isset($_SESSION['role']) == 'seller' && $_SESSION['verified'] == 1) { 
        
        header('location: seller/dashboard.php');
        //exit();
    }
    else if (isset($_SESSION['role']) == 'customer' && $_SESSION['verified'] == 1) {
        header('location: user/user-profile.php'); 
        //exit();
    } 
    else { 
        header('location: home.php'); 
        //exit();
    } 
?> 