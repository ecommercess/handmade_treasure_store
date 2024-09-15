<?php

    require_once '../classes/product.class.php';

    $delete_id = $_POST['delete_id'];

    $product = new Product();

    $delete = $product->deleteRecords($delete_id);

?>