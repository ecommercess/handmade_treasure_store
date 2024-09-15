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
                            <h1>Shopping Cart</h1>
                            <ul class="breadcrumb-menu">
                                <li><a href="../home.php">home</a></li>
                                <li><span>Cart</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- Cart Area Start-->
        <section class="cart-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="../checkout.php" method="post" id="payment-form">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <!--<th class="product-checkout">Checkout</th>-->
                                            <th class="product-thumbnail">Product Display</th>
                                            <th class="cart-product-name">Product Name</th>
                                            <th class="product-price">Unit Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            require_once '../classes/order.class.php';

                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];
                                                $firstname = $_SESSION['firstname'];
                                                $lastname = $_SESSION['lastname'];
                                                $middlename = $_SESSION['middlename'];
                                                $contact_number = $_SESSION['contact_number'];
                                                $address = $_SESSION['address'];
                                                $contact_number = $_SESSION['contact_number'];


                                                $cart = new Order();
                                                // Fetch records for this specific customer
                                                $cart = $cart->fetchAllRecords($user_id);

                                                // Check if the cart is not empty
                                                if (!empty($cart)) {
                                                    // We will now fetch all the records in the array using a loop
                                                    $i = 1;
                                                    $subtotal = 0;
                                                    foreach ($cart as $value) {
                                                        $total = $value['price'] * $value['quantity'];
                                                        $subtotal += $total;
                                                        ?>
                                                        <tr>
                                                            <td class="product-thumbnail"><img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>"></td>
                                                            
                                                            <td class="product-name"><?php echo $value['product_name']; ?></td>
                                                            <input type="hidden" name="product_name[]" value="<?php echo $value['product_name']; ?>">

                                                            <td class="product-price"><span class="amount" data-price="<?php echo $value['price']; ?>"><?php echo $value['price']; ?></span></td>
                                                            <input type="hidden" name="price[]" value="<?php echo $value['price']; ?>">
                                                            
                                                            <td class="product-quantity">
                                                                <div class="cart-plus-minus">
                                                                    <input type="text" id="quantity_<?php echo $i; ?>" name="quantity[]" value="<?php echo $value['quantity']; ?>" min="1">
                                                                </div>
                                                            </td>
                                                            
                                                            <input type="hidden" name="seller_id[]" value="<?php echo $value['seller_id']; ?>">

                                                            <td class="product-subtotal"><span class="subtotal"><?php echo $total; ?></span></td>
                                                            <td class="product-remove"><a href="delete_cart_item.php?item_id=<?php echo $value['id']; ?>"><i class="fa fa-times"></i></a></td>
                                                        </tr>
                                                        <?php 
                                                        $i++; 
                                                    } // End of loop
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 ml-auto">
                                                    <div class="cart-page-total">
                                                        <h2>Cart totals</h2>
                                                        <ul class="mb-20">
                                                            <li>Subtotal <span class="cart-subtotal"><?php echo $subtotal; ?></span></li>
                                                            <li>Total <span class="cart-total"><?php echo $subtotal; ?></span></li>
                                                        </ul>
                                                        <!-- Hidden fields to pass user information -->
                                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
                                                        <input type="hidden" name="middlename" value="<?php echo $middlename; ?>">
                                                        <input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
                                                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                                                        <input type="hidden" name="address" value="<?php echo $address; ?>">
                                                        <input type="hidden" name="contact_number" value="<?php echo $contact_number; ?>">
                                                        <button class="btn theme-btn" type="submit" style="margin-left: 39%;">Proceed to Checkout</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            } else {
                                                echo "<p>Your cart is empty.</p>";
                                            }
                                        } else {
                                            echo "<p>Please log in to view your cart.</p>";
                                        }
                                        ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
        <!-- Cart Area End -->



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

        <script src="https://js.stripe.com/v3/"></script>
        <script src="../js/charge.js"></script>
    </body>


</html>
