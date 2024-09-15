<?php
    require_once '../includes/head.php';
    require_once '../includes/header.php';
?>

        <main>

        <!-- breadcrumb-area-start -->
        <section class="breadcrumb-area" data-background="../img/bg/page-title.png">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb-text text-center">
                            <h1>All Products</h1>
                            <ul class="breadcrumb-menu">
                                <li><a href="index.html">home</a></li>
                                <li><span>shop</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

<!-- shop-area start -->
<section class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- tab filter -->
                <div class="row mb-10">
                    <div class="col-xl-5 col-lg-6 col-md-6">
                        <div class="product-showing mb-40">
                            <p>Showing Total Number of Products</p>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-6">
                        <div class="pro-filter mb-40 f-right">
                            <form action="#">
                                <select name="pro-filter" id="pro-filter">
                                    <option value="1">Shop By</option>
                                    <option value="2">Top Sales</option>
                                    <option value="3">New Product</option>
                                    <option value="4">A to Z Product</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                        <?php
                        require_once '../classes/product.class.php'; 
                        $product = new Product();
                        
                        // Fetch all the records in the array using loop
                        $all_products = $product->fetchAllItems();

                        // Sort the news array by date (most recent first)
                        usort($all_products, function($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });
                        
                        // Display the most recent product on the right side
                        $most_recent = array_shift($all_products);
                        ?>
                        
                            <div class="col-lg-4 col-md-6">
                                <div class="product-wrapper mb-50">
                                    <div class="product-img mb-25">
                                        <a href="product-details.html">
                                            <img src="../uploads/<?php echo $most_recent['product_display']; ?>" alt="<?php echo $most_recent['product_name']; ?>">
                                        </a>
                                        <div class="product-action text-center">
                                            <a href="#" title="Shopping Cart">
                                                <i class="flaticon-shopping-cart"></i>
                                            </a>
                                            <a href="product-details.php?id=<?php echo $most_recent['id']; ?>" title="Quick View">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="pro-cat mb-10">
                                            <a href=""><?php echo $most_recent['product_category']; ?></a>
                                        </div>
                                        <h4>
                                            <a href="product-details.php"><?php echo $most_recent['product_name']; ?></a>
                                        </h4>
                                        <div class="product-meta">
                                            <div class="pro-price">
                                                <span>₱<?php echo $most_recent['price']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach ($all_products as $value) { ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="product-wrapper mb-50">
                                    <div class="product-img mb-25">
                                        <a href="product-details.html">
                                            <img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>">
                                        </a>
                                        <div class="product-action text-center">
                                            <a href="#" title="Shopping Cart">
                                                <i class="flaticon-shopping-cart"></i>
                                            </a>
                                            <a href="product-details.php?id=<?php echo $value['id']; ?>" title="Quick View">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="pro-cat mb-10">
                                            <a href=""><?php echo $value['product_category']; ?></a>
                                        </div>
                                        <h4>
                                            <a href="product-details.php"><?php echo $value['product_name']; ?></a>
                                        </h4>
                                        <div class="product-meta">
                                            <div class="pro-price">
                                                <span>₱<?php echo $value['price']; ?></span>
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

<!-- Mirrored from wphix.com/template/vue/vue/shop-full.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 21 Oct 2023 08:30:39 GMT -->
</html>
