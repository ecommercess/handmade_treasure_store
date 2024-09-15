<?php
    //resume session
   session_start();
    //destroy session
    session_destroy();
    //then send user to home page
    header('location: ../home.php');

?>