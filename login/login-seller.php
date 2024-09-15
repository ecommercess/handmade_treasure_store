<?php
ob_start();
require_once '../classes/seller.class.php';
require_once '../tools/functions.php';

// Resume session here to fetch session values
session_start();
if (isset($_SESSION['logged-in'])) {
    header("location: ../home.php");
    exit();
}

require_once '../includes/head.php';
//require_once '../includes/header.php'; 

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Sanitizing the inputs of the users. Mandatory to prevent injections!
    $user = new Seller;
    $user->email = htmlentities($_POST['email']); 
    $user->password = htmlentities($_POST['password']); 

    $output = $user->login();
        
    if ($output) {            
        $_SESSION['profile_picture'] = $output['profile_picture'];
        $_SESSION['fullname'] = $output['firstname'] . ' ' . $output['middlename'] . ' ' . $output['lastname'] . ' ' . $output['suffix'];
        $_SESSION['email'] = $output['email'];
        $_SESSION['contact_number'] = $output['contact_number'];
        $_SESSION['address'] = $output['address'];
        $_SESSION['logged-in'] = $output['email'] . ' ' . $output['password'];
        $_SESSION['role'] = $output['role'];
        $_SESSION['firstname'] = $output['firstname'];
        $_SESSION['middlename'] = $output['middlename'];
        $_SESSION['lastname'] = $output['lastname'];
        $_SESSION['suffix'] = $output['suffix'];
        $_SESSION['password'] = $output['password'];           
        $_SESSION['user_id'] = $output['id'];

        // Display the page for the following users
        if ($output['role'] == 'seller') {
            $_SESSION['seller_id'] = $output['id']; // Correctly set the seller ID
            header('location: ../seller/dashboard.php');
            exit(); // Always use exit after header to stop further execution
        }
    } else {
        $error = 'Incorrect Account Credentials! Try again.';
    }
}

ob_end_flush();
?>

<main>
    <!-- login Area Start -->
    <section class="login-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="basic-login">
                        <h3 class="text-center mb-60">LOG IN (SELLER)</h3>
                        <form action="login-seller.php" method="post">

                            <?php
                                // Display the error message if there is any.
                                if (isset($error)) {
                                    echo '<div style="text-align: center;"><p class="error" style="color: red;">' . $error . '</p></div>';
                                }
                            ?>

                            <label for="email">Email Address <span>*</span></label>
                            <input name="email" id="email" type="email" placeholder="Enter Email" tabindex="1" required />
                            <label for="password">Password <span>*</span></label>
                            <input name="password" id="password" type="password" placeholder="Enter Password" tabindex="2" required />
                            <!--<div class="login-action mb-20 fix">
                                <span class="log-rem f-left">
                                    <input id="remember" type="checkbox" />
                                    <label for="remember">Remember me!</label>
                                </span>
                                <span class="forgot-login f-right">
                                    <a href="#">Forgot Password?</a>
                                </span>
                            </div>-->
                            <?php
                                // Display the error message if there is any.
                                if (isset($error)) {
                                    echo '<div><p class="error">' . $error . '</p></div>';
                                }
                            ?>
                            <input class="btn theme-btn-2 w-100" type="submit" value="LOG IN" name="login" tabindex="3" style="margin: 0;">
                            <div class="or-divide"><span></span></div>
                            <div style="text-align: center;">
                                <span>Don't have an account? <a href="signup-seller.php" style="color: #fe4536;"> SIGN UP HERE </a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login Area End -->
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
</div>
<!-- end fullscreen search -->

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
