<?php

    require_once '../classes/product.class.php';
    require_once '../vendor/autoload.php';

    $update_id = $_POST['update_id'];

    $product = new Product();

    $value = $product->edit($update_id);

    if(!empty($value)) {

?>



<div class="admin-modal-content">
    <span class="close">&times;</span>
    <h3 class="modal-title">Edit Product</h3>
    <hr>
    <form id="editform" class="form-class" method="post" enctype="multipart/form-data">
    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $value['id']; ?>">

            <!--Product Name-->
            <label for="editProductName" class="form-label">Product Name</label>
            <div class="input-group">
                <input class="form-control" type="text" name="editProductName" id="editProductName" value="<?php echo $value['product_name']; ?>" required>
            </div>     

            <!--Product Display-->
            <label for="file">Upload Product Display</label>
            <div class="hidden-preview">
                <img id="current-file-preview" src="../uploads/<?php echo $value['product_display']; ?>">
            </div>  

            <div class="preview">
                <img id="file-preview" src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>">
            </div>

            <!--Product Display UPLOAD BUTTON-->
            <div class="input-group">
                <p style="font-size: 12px;color: red;font-style: italic;font-weight: lighter;">Max of 5mb. Accepted File Types: .jpg, .jpeg, .png</p>
                <input type="file" name="product_display" id="product_display" accept="image/*" onchange="showPreview(event)" >
            </div> 

            <!--Product Description-->
            <label for="editProductDescription" class="form-label">Description</label>
            <div class="input-group">
                <textarea style="height: 300px; width: 100%;" class="form-control" type="text" name="editProductDescription" id="editProductDescription" rows="4" cols="50" required><?php echo $value['product_description']; ?></textarea>
            </div>

            <!--Category-->
            <label for="editProductCategory" style="font-weight: bold;">Product Category</label>
            <div class="input-group">
                <select id="editProductCategory" name="editProductCategory">
                    <option value="">--Select Category--</option>
                    <option value="Crocheted Item"<?php if ($value['product_category'] == 'CategoryA') { echo ' selected'; } ?>>Crocheted Item</option>
                    <option value="Satin Item"<?php if ($value['product_category'] == 'CategoryB') { echo ' selected'; } ?>>Satin Item</option>
                    <option value="Key Chain"<?php if ($value['product_category'] == 'CategoryC') { echo ' selected'; } ?>>Key Chain</option>
                    <option value="Phone Lace"<?php if ($value['product_category'] == 'CategoryC') { echo ' selected'; } ?>>Phone Lace</option>
                    <option value="Others"<?php if ($value['product_category'] == 'CategoryC') { echo ' selected'; } ?>>Others</option>
                </select>
            </div>


            <!-- Fetch product details and calculate available stock -->
            <?php 
                require_once '../classes/product.class.php';

                // Assuming $value['id'] contains the product ID from your form or session
                $product_id = $value['id'];

                // Create an instance of the Product class
                $productClassInstance = new Product();

                // Fetch product details
                $product = $productClassInstance->fetchProductDetails($product_id);

                // Get the total ordered quantity for the product
                $totalOrderedQuantity = $productClassInstance->getTotalOrderedQuantity($product_id);

                // Calculate the available stock
                $availableStock = $product['stocks'] - $totalOrderedQuantity;
            ?>

            <!-- Display the form input for stocks with available stock and low stock message -->
            <label for="editStocks" class="form-label">Stocks</label>
            <div class="input-group">
                <input class="form-control" type="number" name="editStocks" id="editStocks" value="<?php echo $product['stocks']; ?>" required>
            </div>

            <!-- Display low stock message if applicable -->
            <?php if ($availableStock <= 5): ?>
                <div style="color: red; font-weight: bold;">Your Product is almost out of stock! Kindly Restock</div>
            <?php endif; ?>


            <!--PRICE-->
            <label for="editPrice" class="form-label">Price</label>
            <div class="input-group">
                <input class="form-control" type="number" name="editPrice" id="editPrice" value="<?php echo $value['price']; ?>" required>
            </div>

            <div class="input-group">
            <input type="submit" id="submit" name="submit" value="Save Changes" class="form-btn btn-primary">
            <input type="reset" id="btn-reset" name="btn-reset" hidden>
            
</div>
</form>

        <style>
            #loading-icon {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                background-color: rgba(255, 255, 255, 0.5);
                padding: 10px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #loading-icon img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            #loading-icon span {
                font-size: 16px;
                font-weight: bold;
            }
        </style>

</div>
	
<?php
}
?>

