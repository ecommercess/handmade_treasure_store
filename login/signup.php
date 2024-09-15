<?php
    ob_start();
    require_once '../includes/head.php';
    // require_once '../includes/header.php';
    require_once '../classes/user.class.php';
    require_once '../controllers/CustomerEmailVerification.php';

    if (isset($_POST['submit'])) {
        // Sanitizing the inputs of the users. Mandatory to prevent injections!
        $user = new Users;
        $user->firstname = trim(htmlentities($_POST['firstname']));
        $user->middlename = trim(htmlentities($_POST['middlename']));
        $user->lastname = trim(htmlentities($_POST['lastname']));
        $user->suffix = trim(htmlentities($_POST['suffix']));
        $user->email = trim(htmlentities($_POST['email']));
        $user->contact_number = trim(htmlentities($_POST['contactnumber'])); 
        $user->address = htmlentities($_POST['address']);  
        $user->password = trim(htmlentities($_POST['password']));

        $email = $_POST['email'];
        $token = bin2hex(random_bytes(50)); // generate unique token
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt password
        
        
        if ($user->signup($token)) {
            //TO DO: send verification email to user
            sendEmailVerification($email, $token);
            $_SESSION['id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            // Redirect user to verifying page after saving
            header('location: verifying.php');
            exit(); // Always use exit after header to stop further execution
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
                        <h3 class="text-center mb-60">SIGN UP (CUSTOMER)</h3>
                        <form action="signup.php" method="post" enctype="multipart/form-data">
                            <label for="firstname">Firstname <span>*</span></label>
                            <input name="firstname" id="firstname" type="text" placeholder="Enter Firstname" required/>

                            <label for="lastname">Lastname <span>*</span></label>
                            <input name="lastname" id="lastname" type="text" placeholder="Enter Lastname" required/>

                            <label for="middlename">Middlename <span></span></label>
                            <input name="middlename" id="middlename" type="text" placeholder="Enter Middlename (Optional)" />

                            <label for="suffix">Suffix <span></span></label>
                            <input name="suffix" id="suffix" type="text" placeholder="Enter Suffix (Optional)" />

                            <label for="email">Email Address <span>*</span></label>
                            <input name="email" id="email" type="email" placeholder="Enter Email" required/>

                            <label for="contactnumber">Contact Number <span>*</span></label>
                            <input name="contactnumber" id="contactnumber" type="tel" pattern="\d{11}" maxlength="11" placeholder="Enter Contact Number" required/>

                            <label for="address">Complete Address <span>*</span></label>
                            <input name="address" id="address" type="text" placeholder="Enter Complete Address" required/>

                            <label for="password">Password <span>*</span></label>
                            <input name="password" id="password" type="password" placeholder="Create Password" required/>

                            <label for="confirmpassword">Confirm Password <span>*</span></label>
                            <input name="confirmpassword" id="confirmpassword" type="password" placeholder="Confirm Password" required/>
                            
                            <div class="mt-10"></div>

                            <input class="btn theme-btn-2 w-100" type="submit" id="submit" name="submit" value="SIGN UP">

                            <div class="or-divide"><span></span></div>
                            <div style="text-align: center;">
                                <span>Have an account already? <a href="login.php" style="color: #fe4536;"> LOG IN HERE </a></span>
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
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
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
