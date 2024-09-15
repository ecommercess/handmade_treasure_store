<?php

    require_once '../classes/user.class.php';
    
    $edit_id = $_POST['edit_id'];
    
    $user = new Users();
    
    $update = $user->update($edit_id);


?>