<?php 
    session_start(); // Start the session at the beginning
    require_once 'filter.php'; 
?>
<table class="table table-hover col-12" id="table-cancelled" style="width: 100%;">
<thead>
    <tr>
        <th scope="col">Action</th>
        <th scope="col">Product Name</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Order Total</th>
        <th scope="col">Customer Name</th>
        <th scope="col">Delivery Address</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Status</th>
    </tr>
</thead>
<tbody>
<?php
require_once '../classes/order.class.php'; // Adjust path as per your class location

if(isset($_SESSION['seller_id'])) {
    $seller_id = $_SESSION['seller_id'];
    echo "Seller ID: " . htmlspecialchars($seller_id); // Debugging statement
    $order = new Order();

    // Fetch records for this specific seller
    $orders = $order->fetchCancelledOrder($seller_id);

    // We will now fetch all the records in the array using a loop
    $i = 1;

    // Loop for each record found in the array
    foreach ($orders as $value) { 
?>
    <tr>
        <td></td>
        <td><?php echo htmlspecialchars($value['product_name']); ?></td>
        <td><?php echo htmlspecialchars($value['price']); ?></td>
        <td><?php echo htmlspecialchars($value['quantity']); ?></td>
        <td><?php echo htmlspecialchars($value['order_total']); ?></td>
        <td><?php echo htmlspecialchars($value['fullname']); ?></td>
        <td><?php echo htmlspecialchars($value['address']); ?></td>
        <td><?php echo htmlspecialchars($value['contact_number']); ?></td>
        <td><?php echo htmlspecialchars($value['status']); ?></td>
    </tr>
    <!--End of loop-->
<?php 
        $i++; 
    }
} else {
    echo "Seller ID is not set. Please log in.";
}
?>
</tbody>
</table>
