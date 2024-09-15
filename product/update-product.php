<?php

    require_once '../classes/product.class.php';
    
    $edit_id = $_POST['edit_id'];
    
    $product = new Product();
    
    $update = $product->update($edit_id);


?>