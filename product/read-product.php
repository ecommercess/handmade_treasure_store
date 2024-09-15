<?php
session_start();
require_once '../classes/product.class.php';

if (isset($_SESSION['seller_id'])) {
    $seller_id = $_SESSION['seller_id']; 
    $product = new Product();
    // Fetch records for this specific seller
    $products = $product->fetchAllRecords($seller_id);

    // We will now fetch all the records in the array using a loop
    $i = 1;
    // Loop for each record found in the array
    foreach ($products as $value) { 
        // Start of loop
    ?>
        <tr>
            <!-- Always use echo to output PHP values -->
            <td>
                <div class="action-button">
                    <a title="Edit" href="#" class="me-2 green" id="edit" value="<?php echo $value['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a title="Delete" href="#" class="green" id="delete" value="<?php echo $value['id']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </td>
            <td style="width: 50%;"><img src="../uploads/<?php echo $value['product_display']; ?>" style="width: 20%;"></td>
            <td><?php echo $value['product_name']; ?></td>
            <td><?php echo $value['product_description']; ?></td>
            <td><?php echo $value['product_category']; ?></td>
            
            <?php 
                // Get the product ID from the current loop item
                $product_id = $value['id'];

                // Get the total ordered quantity for the product
                $totalOrderedQuantity = $product->getTotalOrderedQuantity($product_id);

                // Calculate the available stock
                $availableStock = $value['stocks'] - $totalOrderedQuantity;
            ?>
            <td>
                <?php echo $availableStock; ?>
                <?php if ($availableStock <= 5): ?>
                <div class="low-stock-message" style="color: red; font-weight: bold;">Your Product is almost out of stock! Kindly Restock</div>
                <?php endif; ?>
            </td>

            <td><?php echo $value['price']; ?></td>    
        </tr> 
        <!-- End of loop -->
    <?php $i++; } 
} else {
    echo "Seller ID is not set. Please log in.";
}
?>
