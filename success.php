<?php

require __DIR__ . "/vendor/autoload.php";
require 'classes/database.php'; // Ensure you have a file that sets up your database connection

session_start(); // Start the session to access session variables

$stripe_secret_key = "sk_test_51P8e7Q2LPdfCRwvh8sa4dZGkz01iZxh4zVz2SICR75FFDWiTao8xg4brkS4IskcQq1Pj9jBGkBlXMh8xlRnZ0xMy00n30ybP2x";
\Stripe\Stripe::setApiKey($stripe_secret_key);

if (isset($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

    // Get customer details from session metadata or other source
    $fullname = $checkout_session->customer_details->name; // Adjust as per Stripe's actual structure
    $email = $checkout_session->customer_details->email;
    $status = 'Pending'; // Set order status
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID stored in session

    // Initialize database connection
    $database = new Database();
    $conn = $database->connect();

     // Retrieve user's contact_number, address, seller_id from session or database
    $contact_number = isset($_SESSION['contact_number']) ? $_SESSION['contact_number'] : '';
    $address = isset($_SESSION['address']) ? $_SESSION['address'] : '';

    // Retrieve seller_id from the checkout session metadata
    //$seller_id = $checkout_session->metadata->seller_id;


    // Get product details from the checkout session
    $line_items = \Stripe\Checkout\Session::allLineItems($session_id, ['limit' => 100]);

    $order_saved = true;

    foreach ($line_items->data as $item) {
        $product_name = $item->description;
        $quantity = $item->quantity;
        $unit_price = $item->price->unit_amount / 100; // Convert from cents to actual price
        $order_total = $unit_price * $quantity; // Calculate the total order amount

        // Fetch the product ID and seller ID based on the product name (or other identifier if available)
        $sql = "SELECT id, product_display, product_category, seller_id FROM product WHERE product_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_name]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $product_id = $product['id'];
        $product_display = $product['product_display'];
        $product_category = $product['product_category'];
        $seller_id = $product['seller_id'];


        // Insert order details into the database
        $sql = "INSERT INTO `order` (product_id, seller_id, user_id, product_name, product_display, product_category, price, fullname, email, contact_number, address, quantity, order_total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_id, $seller_id, $user_id, $product_name, $product_display, $product_category, $unit_price, $fullname, $email, $contact_number, $address, $quantity, $order_total, $status]);

        if ($stmt->rowCount() === 0) {
            $order_saved = false;
            echo "Error: Failed to save order for $product_name.";
            break;
        }
    }

    if ($order_saved) {
        // Clear the cart in the session
        unset($_SESSION['cart']);

        // Optionally, remove the cart items from the database if you store them there
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);

        // Redirect to home page
        header('Location: customer/myPurchase.php');
        exit; // Make sure to exit after redirect
    }
}

?>
    