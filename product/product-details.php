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
                            <h1>Our Shop</h1>
                            <ul class="breadcrumb-menu">
                                <li><a href="index.html">home</a></li>
                                <li><span>Product Details</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <?php
        
        require_once '../classes/product.class.php'; 
        $product = new Product();
        
        // Check if the product ID is set in the URL
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $product = $product->fetchRecordById($product_id);
            if ($product) {
        ?>

        <?php

        //require_once '../classes/order.class.php';
        require_once '../classes/user.class.php';

        $user = new Users;
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        // Check if user is logged in
        if(isset($_SESSION['user_id'])) {
            $userData = $user -> fetch($_SESSION['user_id']);
        }

        if(isset($_POST['addtoCart'])) {
            $user->id = $id;
            // Set the user_id only if the user is logged in
            if(isset($_SESSION['user_id'])) {
                $user->user_id = $_SESSION['user_id'];
            }
            $user->user_id = $_SESSION['user_id']; // Set the user_id
            $user->seller_id = htmlentities($_POST['seller_id']); 
            $user->product_id = htmlentities($_POST['product_id']); 
            $user->product_name = htmlentities($_POST['product_name']); 
            $user->product_display = htmlentities($_POST['product_display']); 
            $user->price = htmlentities($_POST['price']); 
            $user->quantity = htmlentities($_POST['quantity']); 
            $user->firstname = htmlentities($_POST['firstname']);
            $user->middlename = htmlentities($_POST['middlename']);
            $user->lastname = htmlentities($_POST['lastname']);
            $user->suffix = htmlentities($_POST['suffix']);
            $user->email = htmlentities($_POST['email']);
            $user->contact_number = htmlentities($_POST['contact_number']);
            $user->address = htmlentities($_POST['address']);
            
            
            if ($user->addProductToCart()) {
                $_SESSION['product_added'] = true;
            }
        } else {
            if ($id && $user->fetch($id)){
                $data = $user->fetch($id);
                $_POST['firstname'] = $data['firstname'];
                $_POST['middlename'] = $data['middlename'];
                $_POST['lastname'] = $data['lastname'];
                $_POST['suffix'] = $data['suffix'];
                $_POST['email'] = $data['email'];
                $_POST['contact_number'] = $data['contact_number'];
                $_POST['address'] = $data['address'];
            }
        }
        ?>

        <style>
            /* Custom styles for the modal */
            .modal {
                display: none; 
                position: fixed; 
                z-index: 1; 
                left: 0; 
                top: 0; 
                width: 100%; 
                height: 100%; 
                overflow: auto; 
                background-color: rgb(0,0,0); 
                background-color: rgba(0,0,0,0.4); 
            }
            .modal-content {
                background-color: #fefefe;
                margin: 15% auto; 
                padding: 20px;
                border: 1px solid #888;
                width: 20%; 
            }
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }
            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <!-- shop-area start -->
        <section class="shop-details-area pt-100 pb-100">
            <div class="container">

                <div class="row">
                    <div class="col-xl-6 col-lg-4">
                        <div class="product-details-img mb-10">
                            <div class="tab-content" id="myTabContentpro">
                                <div class="tab-pane fade show active" id="home" role="tabpanel">
                                    <div class="product-large-img">
                                        <img src="../uploads/<?php echo $product['product_display']; ?>" alt="<?php echo $product['product_name']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-thumb-tab mb-30">
                            <ul class="nav" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-selected="true"><img
                                            src="img/product/pro4.jpg" alt=""> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-selected="false"><img
                                            src="img/product/pro5.jpg" alt=""></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile1" role="tab" aria-selected="false"><img
                                            src="img/product/pro6.jpg" alt=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8">
                        <div class="product-details mb-30 pl-30">
                            <h2 class="pro-details-title mb-15"><?php echo $product['product_name'] ?></h2>
                            <div class="details-price mb-20">
                                <span>₱<?php echo $product['price']; ?></span>
                            </div>
                            <div class="product-variant">



                                <div class="product-desc variant-item">
                                    <p><?php echo $product['product_description']; ?></p>
                                </div>

                                <div class="product-info-list variant-item">
                                    <ul>
                                        <li><span>Category:</span> <span class="in-stock"><?php echo $product['product_category']; ?></span></li>

                                        <?php 
                                            include_once '../classes/product.class.php';
                                            $productClassInstance = new Product();

                                            // Get the product ID from the query parameter
                                            $product_id = $_GET['id'];

                                            // Get the product details
                                            $product = $productClassInstance->fetchProductDetails($product_id);

                                            // Get the total ordered quantity for the product
                                            $totalOrderedQuantity = $productClassInstance->getTotalOrderedQuantity($product_id);

                                            // Calculate the available stock
                                            $availableStock = $product['stocks'] - $totalOrderedQuantity;
                                            ?>

                                            <ul>
                                                <li>
                                                    <span>Available Stock:</span> 
                                                    <span class="in-stock"><?php echo $availableStock; ?></span>
                                                </li>
                                                <?php if ($availableStock <= 5): ?>
                                                <li>
                                                    <span class="low-stock-message" style="color: red; font-weight: bold;">Hurry up! Only a few left in stock!</span>
                                                </li>
                                                <li style="display: none;"><span>Seller:</span> <span><?php echo $product['seller_id']; ?></span></li>
                                                <?php endif; ?>
                                            </ul>

                                            <div class="product-action-details variant-item">
                                                <div class="product-details-action">
                                                    <form action="product-details.php?id=<?php echo $product_id; ?>" method="post">
                                                        <div class="plus-minus">
                                                            <div class="cart-plus-minus">
                                                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo $availableStock; ?>" />
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="seller_id" value="<?php echo $product['seller_id']; ?>">
                                                        <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                        <input type="hidden" name="product_display" value="<?php echo $product['product_display']; ?>">
                                                        <input type="hidden" id="firstname" name="firstname" value="<?php echo isset($userData['firstname']) ? $userData['firstname'] : ''; ?>">
                                                        <input type="hidden" id="middlename" name="middlename" value="<?php echo isset($userData['middlename']) ? $userData['middlename'] : ''; ?>">
                                                        <input type="hidden" id="lastname" name="lastname" value="<?php echo isset($userData['lastname']) ? $userData['lastname'] : ''; ?>">
                                                        <input type="hidden" id="suffix" name="suffix" value="<?php echo isset($userData['suffix']) ? $userData['suffix'] : ''; ?>">
                                                        <input type="hidden" id="contact_number" name="contact_number" value="<?php echo isset($userData['contact_number']) ? $userData['contact_number'] : ''; ?>">
                                                        <input type="hidden" id="email" name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>">
                                                        <input type="hidden" id="address" name="address" value="<?php echo isset($userData['address']) ? $userData['address'] : ''; ?>">

                                                        <?php if (!isset($_SESSION['logged-in'])) { ?>
                                                            <div class="details-cart mt-40">
                                                                <a class="btn theme-btn" href="../login/login.php">Add to Cart</a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="details-cart mt-40">
                                                                <input class="btn theme-btn" type="submit" id="addtoCart" name="addtoCart" value="Add to Cart">
                                                            </div>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal HTML -->
                                            <div id="stockModal" class="modal-stock">
                                                <div class="modal-content-stock">
                                                    <span class="close">&times;</span>
                                                    <p>Only <?php echo $availableStock; ?> items left in stock!</p>
                                                </div>
                                            </div>

                                            <script>
                                            document.getElementById('quantity').addEventListener('input', function() {
                                                var maxStock = <?php echo $availableStock; ?>;
                                                var quantity = parseInt(this.value);

                                                if (quantity > maxStock) {
                                                    this.value = maxStock;
                                                    document.getElementById('stockModal').style.display = "block";
                                                }
                                            });

                                            // Get the modal
                                            var modal = document.getElementById('stockModal');

                                            // Get the <span> element that closes the modal
                                            var span = document.getElementsByClassName('close')[0];

                                            // When the user clicks on <span> (x), close the modal
                                            span.onclick = function() {
                                                modal.style.display = "none";
                                            }

                                            // When the user clicks anywhere outside of the modal, close it
                                            window.onclick = function(event) {
                                                if (event.target == modal) {
                                                    modal.style.display = "none";
                                                }
                                            }
                                            </script>

                                            <style>
                                            .modal-stock {
                                                display: none; 
                                                position: fixed; 
                                                z-index: 1; 
                                                left: 0;
                                                top: 0;
                                                width: 100%; 
                                                height: 100%; 
                                                overflow: auto; 
                                                background-color: rgb(0,0,0); 
                                                background-color: rgba(0,0,0,0.4); 
                                                padding-top: 60px; 
                                            }

                                            .modal-content-stock {
                                                background-color: #fefefe;
                                                margin: 5% auto; 
                                                padding: 20px;
                                                border: 1px solid #888;
                                                width: 20%; 
                                            }

                                            .close {
                                                color: #aaa;
                                                float: right;
                                                font-size: 28px;
                                                font-weight: bold;
                                            }

                                            .close:hover,
                                            .close:focus {
                                                color: black;
                                                text-decoration: none;
                                                cursor: pointer;
                                            }
                                            </style>


                                            <!-- The Modal -->
                                            <div id="myModal" class="modal">
                                            <div class="modal-content">
                                                <span class="close">&times;</span>
                                                <p style="text-align: center;">Product added to cart!</p>
                                                <p style="text-align: center;"><a href="../cart/cart.php">View Cart</a></p>
                                            </div>
                                            </div>

                                            <script src="path/to/jquery.js"></script>
                                            <script src="path/to/bootstrap.js"></script>

                                            <script>
                                             document.addEventListener('DOMContentLoaded', (event) => {
                                                <?php if (isset($_SESSION['product_added'])): ?>
                                           
                                            var modal = document.getElementById("myModal");
                                            var span = document.getElementsByClassName("close")[0];

                                            modal.style.display = "block";

                                            span.onclick = function() {
                                                modal.style.display = "none";
                                            }

                                            window.onclick = function(event) {
                                                if (event.target == modal) {
                                                    modal.style.display = "none";
                                                }
                                            }

                                            // Unset the session variable
                                            <?php unset($_SESSION['product_added']); ?>
                                        <?php endif; ?>
                                    });
                                    </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                <?php
                } else {
                // Display error message if product is not found
                echo 'Product is not available.';
            }
        } else {
            // Display error message if product ID is not set in URL
            echo 'Invalid product ID.';
        }
        ?>
        </div>
    </div>
</section>
<!-- shop-area end -->
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
