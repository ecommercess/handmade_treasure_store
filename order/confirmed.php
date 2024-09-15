<?php
session_start(); // Start the session at the beginning
require_once 'filter.php'; 
?>

<!-- Modal for adding tracking number -->
<div class="modal fade" id="addTrackingModal" tabindex="-1" role="dialog" aria-labelledby="addTrackingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTrackingModalLabel">Add Tracking Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="trackingForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="trackingNumber">Tracking Number:</label>
            <input type="text" class="form-control" id="trackingNumber" name="trackingNumber" required>
            <input type="hidden" id="orderId" name="orderId" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<table class="table table-hover col-12" id="table-confirmed" style="width: 100%;">
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
    $orders = $order->fetchConfirmedOrder($seller_id);

    // Loop for each record found in the array
    foreach ($orders as $value) { 
?>
    <tr>
        <td>
            <div class="action-button">
                <button class="btn btn-success add-tracking-button" data-order-id="<?php echo htmlspecialchars($value['id']); ?>" data-toggle="modal" data-target="#addTrackingModal">Add Tracking Number</button>
            </div>
        </td>
        <td><?php echo htmlspecialchars($value['product_name']); ?></td>
        <td><?php echo htmlspecialchars($value['price']); ?></td>
        <td><?php echo htmlspecialchars($value['quantity']); ?></td>
        <td><?php echo htmlspecialchars($value['order_total']); ?></td>
        <td><?php echo htmlspecialchars($value['fullname']); ?></td>
        <td><?php echo htmlspecialchars($value['address']); ?></td>
        <td><?php echo htmlspecialchars($value['contact_number']); ?></td>
        <td><?php echo htmlspecialchars($value['status']); ?></td>
    </tr>
<?php 
    }
} else {
    echo "Seller ID is not set. Please log in.";
}
?>
</tbody>
</table>

<script>
// JavaScript for handling modal form submission
$(document).ready(function() {
    $('.add-tracking-button').click(function() {
        var orderId = $(this).data('order-id');
        $('#orderId').val(orderId);
    });

    $('#trackingForm').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'process_tracking.php',
            data: formData,
            success: function(response) {
                alert(response); // Optional: Display success message
                $('#addTrackingModal').modal('hide'); // Hide the modal after submission
                window.location.reload(); // Reload the page after updating
            },
            error: function(err) {
                console.error('Error:', err);
                alert('Failed to add tracking number.');
            }
        });
    });
});
</script>
<!-- Include necessary CSS and JavaScript for modal -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>