<?php
session_start();
require_once '../classes/order.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId']) && isset($_POST['trackingNumber'])) {
    $order_id = $_POST['orderId'];
    $tracking_number = $_POST['trackingNumber'];
    
    $order = new Order();
    $success = $order->addTrackingNumber($order_id, $tracking_number);
    
    if ($success) {
        echo "Tracking number added successfully.";
    } else {
        echo "Failed to add tracking number.";
    }
} else {
    echo "Invalid request.";
}
?>
