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
                            <h1>All Items</h1>
                            <ul class="breadcrumb-menu">
                                <li><a href="../home.php">home</a></li>
                                <li><span>shop</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <?php
        
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

                </div>
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                        <?php
                        require_once '../classes/product.class.php'; 
                        $product = new Product();

                        // Fetch all the records in the array using loop
                        $all_products = $product->fetchKeyChainsItems();
                        
                        // Loop through each product in the list
                        foreach ($all_products as $key => $value) {

                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="product-wrapper mb-50">
                                    <div class="product-img mb-25">
                                        <a href="../product-details.php?id=<?php echo $value['id']; ?>">
                                            <img src="../uploads/<?php echo $value['product_display']; ?>" alt="<?php echo $value['product_name']; ?>">
                                        </a>

                                        <div class="product-action text-center">
                                            <?php if (!isset($_SESSION['logged-in'])) { ?>
                                                <a href="../login/login.php" title="Add to Cart">
                                                    <i class="flaticon-shopping-cart"></i> 
                                                </a>
                                                <a href="../product/product-details.php?id=<?php echo $value['id']; ?>" title="View Product">
                                                    <i class="flaticon-eye"></i>
                                                </a>
                                            <?php } else { ?>
                                                <form action="all.php?id=<?php echo $id; ?>" method="post" class="add-to-cart-form">
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
                                                    <a href="../product/product-details.php?id=<?php echo $value['id']; ?>" title="View Product">
                                                        <i class="flaticon-eye"></i>
                                                    </a>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="product-content">
                                        <div class="pro-cat mb-10">
                                            <a><?php echo $value['product_category']; ?></a>
                                        </div>
                                        <h4>
                                            <a href="../product/product-details.php?id=<?php echo $value['id']; ?>"><?php echo $value['product_name']; ?></a>
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
    <p style="text-align: center;"><a href="../cart/cart.php">View Cart</a></p>
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
