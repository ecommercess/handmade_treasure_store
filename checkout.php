<?php

require __DIR__ . "/vendor/autoload.php";
require 'classes/database.php'; // Make sure to require your database connection file

session_start(); // Start the session to access session variables

$stripe_secret_key = "sk_test_51P8e7Q2LPdfCRwvh8sa4dZGkz01iZxh4zVz2SICR75FFDWiTao8xg4brkS4IskcQq1Pj9jBGkBlXMh8xlRnZ0xMy00n30ybP2x";
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Capture customer details from POST request
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$address = $_POST['address'];
$contact_number = $_POST['contact_number'];
$seller_id = $_POST['seller_id']; // Capture the seller_id from POST request

$product_names = $_POST['product_name'];
$quantities = $_POST['quantity'];
$unit_prices = $_POST['price'];
$user_id = $_SESSION['user_id']; // Assuming you have the user ID stored in session

$line_items = [];
for ($i = 0; $i < count($product_names); $i++) {
    $line_items[] = [
        'quantity' => $quantities[$i],
        'price_data' => [
            'currency' => 'php',
            'unit_amount' => $unit_prices[$i] * 100,
            'product_data' => [
                'name' => $product_names[$i],
            ],
        ],
    ];
}

// Create a new Stripe Checkout session with customer details
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/myecom/success.php?session_id={CHECKOUT_SESSION_ID}",
    "cancel_url" => "http://localhost/myecom/home.php",
    "locale" => "auto",
    "line_items" => $line_items,
    'metadata' => [
        'user_id' => $user_id,
        'fullname' => $fullname,
        'email' => $email,
        'address' => $address,
        'contact_number' => $contact_number,
        //'seller_id' => $seller_id, // Add seller_id to the metadata
    ],
]);

// Redirect the customer to the Stripe Checkout session
http_response_code(303);
header("Location: " . $checkout_session->url);

?>
