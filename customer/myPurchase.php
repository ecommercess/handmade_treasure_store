<?php
require_once '../includes/head.php';
require_once '../includes/header.php';
?>

<main>

<!-- breadcrumb-area-start -->
<section class="breadcrumb-area" data-background="img/bg/page-title.png">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-text text-center">
                    <h1>My Purchase</h1>
                    <ul class="breadcrumb-menu">
                        <li><a href="index.html">home</a></li>
                        <li><span>My Purchase</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->

<!-- Tab Area Start -->
<section class="purchase-area pt-100 pb-100">
    <div class="container">
        <ul class="nav nav-tabs mb-4" id="purchaseTab" role="tablist" style="width: 100%; display: flex; justify-content: space-between;">
            <li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link active" id="to-pay-tab" data-toggle="tab" href="#to-pay" role="tab" aria-controls="to-pay" aria-selected="true">Pending</a>
            </li>
            <li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link" id="to-ship-tab" data-toggle="tab" href="#to-ship" role="tab" aria-controls="to-ship" aria-selected="false">To Ship</a>
            </li>
            <li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link" id="to-receive-tab" data-toggle="tab" href="#to-receive" role="tab" aria-controls="to-receive" aria-selected="false">To Receive</a>
            </li>
            <li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
            </li>
            <!--<li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
            </li>-->
            <!--<li class="nav-item" style="flex: 1; text-align: center; margin: 0 5px;">
                <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All</a>
            </li>-->
        </ul>
        <div class="tab-content" id="purchaseTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <!-- Content for All -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getAllOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                             <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads<?php echo $value['product_display'] ;?>" alt=""></td>
                                <td><?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?></td>
                                <td><?php echo $value['order_total']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="to-pay" role="tabpanel" aria-labelledby="to-pay-tab">
                <!-- Content for Pending -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getPendingOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                            <!-- Sample data for To Pay Orders -->
                            <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>" style="width: 20%;"></td>
                                <td>₱<?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?>x</td>
                                <td>₱<?php echo $value['order_total']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                                <!-- <td>Cancel Button</td> -->
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="to-ship" role="tabpanel" aria-labelledby="to-ship-tab">
                <!-- Content for To Ship -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getConfirmedOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                            <!-- Sample data for To Ship Orders -->
                            <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>" style="width: 20%;"></td>
                                <td><?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?></td>
                                <td><?php echo $value['order_total']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="to-receive" role="tabpanel" aria-labelledby="to-receive-tab">
                <!-- Content for To Receive -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Tracking Number</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getIntransitOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                            <!-- Sample data for To Receive Orders -->
                            <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>" style="width: 20%;"></td>
                                <td><?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?></td>
                                <td><?php echo $value['order_total']; ?></td>
                                <td>
                                    <a href="https://www.jtexpress.ph/trajectoryQuery?flag=1&billcode=<?php echo htmlspecialchars($value['tracking_number']); ?>" target="_blank" style="color: blue;">
                                        <?php echo htmlspecialchars($value['tracking_number']); ?>
                                    </a>
                                </td>
                                <td><?php echo $value['status']; ?></td>
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                <!-- Content for Completed -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getCompletedOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                             <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>" style="width: 20%;"></td>
                                <td><?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?></td>
                                <td><?php echo $value['order_total']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                <!-- Content for Cancelled -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Assuming you have a method to fetch pending orders in your Order class
                            require_once '../classes/order.class.php'; // Adjust path as per your class location

                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $order = new Order();

                                // Fetch records for this specific seller
                                $order = $order->getCancelledOrders($user_id);

                                // We will now fetch all the records in the array using a loop
                                $i = 1;

                                // Loop for each record found in the array
                                foreach ($order as $value) { 
                                // Start of loop

                            ?>
                             <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>" style="width: 20%;"></td>
                                <td><?php echo $value['price']; ?></td>
                                <td><?php echo $value['quantity']; ?></td>
                                <td><?php echo $value['order_total']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                            </tr>
                            <?php $i++; }
                            } else {
                                 echo "User ID is not set. Please log in.";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Tab Area End -->

</main>

<!-- footer start -->
<?php
    require_once '../includes/footer.php';
?>
<!-- footer end -->

<!-- Fullscreen search -->
<div class="search-wrap">
    <div class="search-inner">
        <i class="fas fa-times search-close" id="search-close"></i>
        <div class="search-cell">
            <form method="get">
                <div class="search-field-holder">
                    <input type="search" class="main-search-input" placeholder="Search Entire Store...">
                </div>
            </form>
        </div>
    </div>
</div> <!-- end fullscreen search -->

<!-- JS here -->
<script src="../js/vendor/jquery-1.12.4.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/isotope.pkgd.min.js"></script>
<script src="../js/slick.min.js"></script>
<script src="../js/jquery.meanmenu.min.js"></script>
<script src="../js/ajax-form.js"></script>
<script src="../js/wow.min.js"></script>
<script src="../js/jquery.scrollUp.min.js"></script>
<script src="../js/jquery.final-countdown.min.js"></script>
<script src="../js/imagesloaded.pkgd.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
