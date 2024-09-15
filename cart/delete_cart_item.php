<?php
session_start();
require_once '../classes/order.class.php';

if (isset($_GET['item_id']) && isset($_SESSION['user_id'])) {
    $item_id = $_GET['item_id'];
    $user_id = $_SESSION['user_id'];
    
    $order = new Order();
    if ($order->deleteCartItem($item_id, $user_id)) {
        header("Location: cart.php"); // Redirect back to the cart page
        exit();
    } else {
        echo "Error deleting item.";
    }
} else {
    echo "Invalid request.";
}

