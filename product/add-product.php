<?php
    
    require_once '../classes/product.class.php';  
    require_once '../tools/functions.php';

    $product = new Product();
    $create = $product->insert();
?>