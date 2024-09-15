<?php
session_start();
require_once '../classes/order.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    $order = new Order();
    $success = $order->confirm_order($order_id);
    
    if ($success) {
        // Optionally, you can set a session message or handle any other logic here
        $_SESSION['message'] = "Order confirmed successfully.";
    } else {
        $_SESSION['message'] = "Failed to confirm order.";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

// Redirect back to the previous page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
