<?php

    //resume session here to fetch session values
    session_start();
    /*
        if user is not login then redirect to login page,
        this is to prevent users from accessing pages that requires
        authentication such as the dashboard
    */

    //if the above code is false then html below will be displayed

?>

<!-- header start -->
<header>
    <div id="header-sticky" class="header-area box-90">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-6 col-md-6 col-7 col-sm-5 d-flex align-items-center pos-relative">
                    <div class="logo">
                        <a href="index.html"><img src="img/logo/logo.png" alt=""></a>
                    </div>

                    <div class="category-menu">
                        <h4>Category</h4>
                        <ul>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Table lamp</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Furniture</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Chair</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Men</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Women</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Cloth</a></li>
                            <li><a href="shop.html"><i class="flaticon-shopping-cart-1"></i> Trend</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-6 col-md-8 col-8 d-none d-xl-block">
                    <div class="main-menu text-center">
                        <nav id="mobile-menu">
                            <ul>
                                <li><a href="../home.php">Home</a></li>
                                <li><a href="#">Categories</a>
                                    <ul class="submenu">
                                        <li><a href="../categories/crocheted.php">Crocheted Items</a></li>
                                        <li><a href="../categories/satin.php">Satin Items</a></li>
                                        <li><a href="../categories/keychains.php">Key Chains</a></li>
                                        <li><a href="../categories/phonelaces.php">Phone Laces</a></li>
                                        <li><a href="../categories/others.php">Others</a></li>
                                        <li><a href="../categories/all.php">All</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="../about/about.php">About Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6 col-5 col-sm-7 pl-0">
                    <div class="header-right f-right">
                        <ul>
                            <li class="login-btn"><a href="login/login.php"><i class="far fa-user"></i></a>
                                <ul class="minicart">
                                    <li>
                                    <?php
                                    if (!isset($_SESSION['logged-in'])) {
                                    ?>
                                        <div class="checkout-link">
                                            <a href="../login/login.php">Customer</a>
                                            <a class="red-color" href="../login/login-seller.php">Seller</a>
                                        </div>
                                        <?php
                                        } 
                                        else {
                                            ?>
                                            <div class="checkout-link">
                                                <a href="../customer/myAccount.php">My Account</a>
                                                <a href="../customer/myPurchase.php">My Purchase</a>
                                                <a href="../login/logout.php">Logout</a>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                    </li>
                                </ul>

                                <?php
                                require_once '../classes/order.class.php';

                                // Assuming session is already started
                                if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];
                                    $order = new Order();
                                    $totalItems = $order->fetchTotalItems($user_id);
                                } else {
                                    $totalItems = 0;
                                }
                                ?>

                                <li class="d-shop-cart"><a href="../cart/cart.php"><i class="flaticon-shopping-cart"></i> <span class="cart-count"><?php echo $totalItems; ?></span></a>                                
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