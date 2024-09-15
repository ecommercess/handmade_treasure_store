<?php
    //resume session here to fetch session values
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Handmadetreasure Store</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="">
	<link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png">

	<!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/meanmenu.css">
    <link rel="stylesheet" href="css/meanmenu.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
    <body>
<!-- header start -->
<header>
    <div id="header-sticky" class="header-area box-90">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-6 col-md-6 col-7 col-sm-5 d-flex align-items-center pos-relative">
                    <div class="logo">
                        <a href="home.php"><img src="img/logo/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-6 col-md-8 col-8 d-none d-xl-block">
                    <div class="main-menu text-center">
                        <nav id="mobile-menu">
                            <ul>
                                <li><a href="home.php">Home</a></li> 
                                <li><a href="#">Categories</a>
                                    <ul class="submenu"> 
                                        <li><a href="categories/crocheted.php">Crocheted Items</a></li>
                                        <li><a href="categories/satin.php">Satin Items</a></li>
                                        <li><a href="categories/keychains.php">Key Chains</a></li>
                                        <li><a href="categories/phonelaces.php">Phone Laces</a></li>
                                        <li><a href="categories/others.php">Others</a></li>
                                        <li><a href="categories/all.php">All</a></li>
                                    </ul>
                                </li>
                                <li><a href="about/about.php">About Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6 col-5 col-sm-7 pl-0">
                    <div class="header-right f-right">
                        <ul>
                            <!--<li class="search-btn">
                                <a class="search-btn nav-search search-trigger" href="#"><i class="fas fa-search"></i></a>
                            </li>-->

                            <li class="login-btn"><a href="login/login.php"><i class="far fa-user"></i></a>
                                <ul class="minicart">
                                    <li>
                                        
                                    <?php
                                    if (!isset($_SESSION['logged-in'])) {
                                    ?>
                                        <div class="checkout-link">
                                            <a href="login/login.php">Customer</a>
                                            <a class="red-color" href="login/login-seller.php">Seller</a>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="checkout-link">
                                            <a href="customer/myAccount.php">My Account</a>
                                            <a href="customer/myPurchase.php">My Purchase</a>
                                            <a href="login/logout.php">Logout</a>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    </li>
                                </ul>
                                <?php
                                require_once 'classes/order.class.php';

                                // Assuming session is already started
                                if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];
                                    $order = new Order();
                                    $totalItems = $order->fetchTotalItems($user_id);
                                } else {
                                    $totalItems = 0;
                                }
                                ?>

                                <li class="d-shop-cart"><a href="cart/cart.php"><i class="flaticon-shopping-cart"></i> <span class="cart-count"><?php echo $totalItems; ?></span></a>        
                    </div>
                </div>
                <div class="col-12 d-xl-none">
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->

        <main>
            <!-- slider-area start -->
            <section class="slider-area pos-relative">
                <div class="slider-active">
                    <div class="single-slider slide-1-style slide-height d-flex align-items-center" style="background: radial-gradient(#fff, #ffd6d6);">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="slide-content">
                                        <span data-animation="fadeInRight" data-delay=".2s">Treasure Every Occasion</span>
                                        <h1 data-animation="fadeInUp" data-delay=".5s">Handmade Treasure Store</h1>
                                        <div class="slide-btn">
                                            <a class="btn theme-btn" href="shop.html" data-animation="fadeInLeft" data-delay=".7s">shop now</a>
                                            <a class="btn white-btn" href="login/signup-seller.php" data-animation="fadeInRight" data-delay=".9s">start selling</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <img src="img/banner/image.jpg" alt="" style="margin-left: 70px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- slider-area end -->

        <?php
        require_once 'classes/user.class.php';

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
            $user->product_id = htmlentities($_POST['product_id']); 
            $user->seller_id = htmlentities($_POST['seller_id']); 
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

<!-- brandnew products-area start -->
<section class="product-area box-90 pt-45 pb-40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5 col-lg-12">
                <div class="area-title mb-50">
                    <h2>Brand New Products</h2>
                    <p>Browse the huge variety of our products</p>
                </div>
            </div>
            <div class="col-xl-7 col-lg-4 col-md-5">
                <div class="vue-btn text-left text-md-right mb-50">
                    <a href="categories/all.php" class="btn theme-btn">See All</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <?php 
                            require_once 'classes/product.recent.php';
                            $product = new Product();
                            // Fetch the most recent 6 records from the database
                            $product_list = $product->fetchRecentRecords(6);
                            // Loop through each product in the list
                            foreach ($product_list as $key => $value) {
                            ?> 
                            <div class="col-lg-4 col-md-6 mb-50">
                                <div class="product-wrapper">
                                    <div class="product-img mb-25">
                                        <a href="product/product-details.php?id=<?php echo $value['id']; ?>">
                                            <img src="uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>">
                                        </a>
                                        
                                        <div class="product-action text-center">
                                            <?php if (!isset($_SESSION['logged-in'])) { ?>
                                                <a href="login/login.php" title="Add to Cart">
                                                    <i class="flaticon-shopping-cart"></i> 
                                                </a>
                                                <a href="product/product-details.php?id=<?php echo $value['id']; ?>" title="View Product">
                                                    <i class="flaticon-eye"></i>
                                                </a>
                                            <?php } else { ?>
                                                <form action="home.php?id=<?php echo $id; ?>" method="post" class="add-to-cart-form">
                                                    <input type="hidden" name="quantity" value="1" min="1" />
                                                    <input type="hidden" name="product_id" value="<?php echo $value['id']; ?>">
                                                    <input type="hidden" name="product_name" value="<?php echo $value['product_name']; ?>">
                                                    <input type="hidden" name="seller_id" value="<?php echo $value['seller_id']; ?>">
                                                    <input type="hidden" name="price" value="<?php echo $value['price']; ?>">
                                                    <input type="hidden" name="product_display" value="<?php echo $value['product_display']; ?>">
                                                    <input type="hidden" id="firstname" name="firstname" value="<?php echo isset($userData['firstname']) ? $userData['firstname'] : ''; ?>">
                                                    <input type="hidden" id="middlename" name="middlename" value="<?php echo isset($userData['middlename']) ? $userData['middlename'] : ''; ?>">
                                                    <input type="hidden" id="lastname" name="lastname" value="<?php echo isset($userData['lastname']) ? $userData['lastname'] : ''; ?>">
                                                    <input type="hidden" id="suffix" name="suffix" value="<?php echo isset($userData['suffix']) ? $userData['suffix'] : ''; ?>">
                                                    <input type="hidden" id="contact_number" name="contact_number" value="<?php echo isset($userData['contact_number']) ? $userData['contact_number'] : ''; ?>">
                                                    <input type="hidden" id="email" name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>">
                                                    <input type="hidden" id="address" name="address" value="<?php echo isset($userData['address']) ? $userData['address'] : ''; ?>">
                                                    <button type="submit" id="addtoCart" name="addtoCart" value="Add to Cart" title="Add to Cart">
                                                        <i class="flaticon-shopping-cart"></i>
                                                    </button>
                                                    <a href="product/product-details.php?id=<?php echo $value['id']; ?>" title="View Product">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="product-content">
                                        <div class="pro-cat mb-10">
                                            <a><?php echo $value['product_category'];?></a>
                                        </div>
                                        <h4>
                                            <a href="product/product-details.php?id=<?php echo $value['id']; ?>"><?php echo $value['product_name']; ?></a>
                                        </h4>
                                        <div class="product-meta">
                                            <div class="pro-price">
                                                <span>₱<?php echo number_format($value['price'], 2); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>

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

<!-- The Modal -->
<div id="myModal" class="modal">
<div class="modal-content">
    <span class="close">&times;</span>
    <p style="text-align: center;">Product added to cart!</p>
    <p style="text-align: center;"><a href="cart/cart.php">View Cart</a></p>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        <?php if (isset($_SESSION['product_added'])): ?>
        // Show the modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        modal.style.display = "block";

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
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
<!-- brandnew products-area end -->

            

            

<?php
        require_once 'classes/user.class.php';

        $user = new Users;
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        // Check if user is logged in
        if(isset($_SESSION['user_id'])) {
            $userData = $user -> fetch($_SESSION['user_id']);
        }

        if(isset($_POST['addtoCartTopItem'])) {
            $user->id = $id;
            // Set the user_id only if the user is logged in
            if(isset($_SESSION['user_id'])) {
                $user->user_id = $_SESSION['user_id'];
            }
            $user->user_id = $_SESSION['user_id']; // Set the user_id   
            $user->product_id = htmlentities($_POST['product_id']); 
            $user->seller_id = htmlentities($_POST['seller_id']); 
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

<!-- brandnew products-area start -->
<section class="product-area box-90 pt-45 pb-40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5 col-lg-12">
                <div class="area-title mb-50">
                    <h2>Best Seller Products</h2>
                    <p>Browse the huge variety of our products</p>
                </div>
            </div>
            <div class="col-xl-7 col-lg-4 col-md-5">
                <div class="vue-btn text-left text-md-right mb-50">
                    <a href="categories/all.php" class="btn theme-btn">See All</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                        <?php 
                        require_once 'classes/order.class.php';
                        $order = new Order();
                        // Fetch the top 5 most frequently ordered products from the database
                        $top_items = $order->getSaleableProducts();
                        // Loop through each product in the list
                        foreach ($top_items as $key => $value) {
                        ?> 
                        <div class="col-lg-4 col-md-6 mb-50">
                            <div class="product-wrapper">
                                <div class="product-img mb-25">
                                    <a href="product/product-details.php?id=<?php echo $value['product_id']; ?>">
                                        <img src="uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>">
                                    </a>
                                    
                                    <div class="product-action text-center">
                                        <?php if (!isset($_SESSION['logged-in'])) { ?>
                                            <a href="login/login.php" title="Add to Cart">
                                                <i class="flaticon-shopping-cart"></i> 
                                            </a>
                                            <a href="product/product-details.php?id=<?php echo $value['product_id']; ?>" title="View Product">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                        <?php } else { ?>
                                            <form action="home.php?id=<?php echo $value['product_id']; ?>" method="post" class="add-to-cart-form">
                                                <input type="hidden" name="quantity" value="1" min="1" />
                                                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $value['product_name']; ?>">
                                                <input type="hidden" name="seller_id" value="<?php echo $value['seller_id']; ?>">
                                                <input type="hidden" name="price" value="<?php echo $value['price']; ?>">
                                                <input type="hidden" name="product_display" value="<?php echo $value['product_display']; ?>">
                                                <input type="hidden" id="firstname" name="firstname" value="<?php echo isset($userData['firstname']) ? $userData['firstname'] : ''; ?>">
                                                <input type="hidden" id="middlename" name="middlename" value="<?php echo isset($userData['middlename']) ? $userData['middlename'] : ''; ?>">
                                                <input type="hidden" id="lastname" name="lastname" value="<?php echo isset($userData['lastname']) ? $userData['lastname'] : ''; ?>">
                                                <input type="hidden" id="suffix" name="suffix" value="<?php echo isset($userData['suffix']) ? $userData['suffix'] : ''; ?>">
                                                <input type="hidden" id="contact_number" name="contact_number" value="<?php echo isset($userData['contact_number']) ? $userData['contact_number'] : ''; ?>">
                                                <input type="hidden" id="email" name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>">
                                                <input type="hidden" id="address" name="address" value="<?php echo isset($userData['address']) ? $userData['address'] : ''; ?>">
                                                <button type="submit" id="addtoCart" name="addtoCartTopItem" value="Add to Cart" title="Add to Cart">
                                                    <i class="flaticon-shopping-cart"></i>
                                                </button>
                                                <a href="product/product-details.php?id=<?php echo $value['product_id']; ?>" title="View Product">
                                                    <i class="flaticon-eye"></i>
                                                </a>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="product-content">
                                    <div class="pro-cat mb-10">
                                        <a><?php echo $value['product_category'];?></a>
                                    </div>
                                    <h4>
                                        <a href="product/product-details.php?id=<?php echo $value['product_id']; ?>"><?php echo $value['product_name']; ?></a>
                                    </h4>
                                    <div class="product-meta">
                                        <div class="pro-price">
                                            <span>₱<?php echo number_format($value['price'], 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>

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

<!-- The Modal -->
<div id="myModal" class="modal">
<div class="modal-content">
    <span class="close">&times;</span>
    <p style="text-align: center;">Product added to cart!</p>
    <p style="text-align: center;"><a href="cart/cart.php">View Cart</a></p>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        <?php if (isset($_SESSION['product_added'])): ?>
        // Show the modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        modal.style.display = "block";

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
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
<!-- brandnew products-area end -->


        </main>

<!-- footer start -->
<footer>
    <div class="footer-area box-90 pt-100 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-5 col-md-6 ">
                    <div class="footer-widget mb-40">
                        <div class="footer-logo">
                            <h3>Handmade Treasure Strore</h3>
                        </div>
                        <p>Thank you for choosing Handmade TreasureStrore! Explore our top-quality products with secure payments and fast shipping. 
                            Our dedicated support team is here for you. Stay tuned for exclusive offers and promotions. Happy shopping with us!
                        </p>
                        <div class="footer-time d-flex mt-30">
                            <div class="time-icon">
                                <img src="img/icon/time.png" alt="">
                            </div>
                            <div class="time-text">
                                <span>Got Questions ? Call us 24/7!</span>
                                <h2>(0600) 874 548</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-3 d-lg-none d-xl-block">
                    <div class="footer-widget pl-50 mb-40">
                        <h3>Social Media</h3>
                        <ul class="footer-link">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">TikTok</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-3 d-lg-none d-xl-block">
                    <div class="footer-widget pl-30 mb-40">
                        <h3>Location</h3>
                        <ul class="footer-link">
                            <li><a href="#">Philippines</a></li>
                            <li><a href="#">Japan</a></li>
                            <li><a href="#">China</a></li>
                            <li><a href="#">South Korea</a></li>
                            <li><a href="#">Vietnam</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-widget mb-40">
                        <h3>About</h3>
                        <ul class="footer-link">
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#"> Privacy Policy</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-5 col-md-6">
                    <div class="footer-widget mb-40">
                        <div class="footer-banner">
                            <a href=""><img src="img/banner/image.jpg" alt=""></a>
                        </div>
                    </div>
                </div> -
            </div>
        </div>
    </div>
</footer>
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
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/one-page-nav-min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.meanmenu.min.js"></script>
        <script src="js/ajax-form.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
        <script src="js/jquery.final-countdown.min.js"></script>
        <script src="js/imagesloaded.pkgd.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>

</html>
