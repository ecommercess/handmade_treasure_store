<?php
ob_start(); // Start output buffering

require_once '../includes/head.php';
require_once '../includes/header.php';
require_once '../classes/user.class.php';

$user = new Users();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $user->id = $_GET['id'];
    $user->firstname = htmlentities($_POST['firstname']);
    $user->middlename = htmlentities($_POST['middlename']);
    $user->lastname = htmlentities($_POST['lastname']);
    $user->suffix = htmlentities($_POST['suffix']);
    $user->email = htmlentities($_POST['email']);
    $user->contact_number = htmlentities($_POST['contact_number']); // sanitize contact number
    $user->address = htmlentities($_POST['address']); // sanitize address

    if ($user->editUser()) {
        // Update session variables with new values
        $_SESSION['firstname'] = $user->firstname;
        $_SESSION['middlename'] = $user->middlename;
        $_SESSION['lastname'] = $user->lastname;
        $_SESSION['suffix'] = $user->suffix;
        $_SESSION['email'] = $user->email;
        $_SESSION['contact_number'] = $user->contact_number;
        $_SESSION['address'] = $user->address;

        // Redirect user to profile page after saving
        header('Location: myAccount.php');
        exit;
    }
} else {
    if ($user->fetch($_GET['id'])) {
        $data = $user->fetch($_GET['id']);
        $_POST['profile_picture'] = $data['profile_picture'];
        $_POST['firstname'] = $data['firstname'];
        $_POST['middlename'] = $data['middlename'];
        $_POST['lastname'] = $data['lastname'];
        $_POST['suffix'] = $data['suffix'];
        $_POST['email'] = $data['email'];
        $_POST['contact_number'] = $data['contact_number'];
        $_POST['address'] = $data['address'];
    }
}

$profile_picture = $_SESSION['profile_picture'];

ob_end_flush(); // End output buffering and send output to browser
?>


<main>

    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area" data-background="img/bg/page-title.png">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>My Account</h1>
                        <ul class="breadcrumb-menu">
                            <li><a href="index.html">home</a></li>
                            <li><span>My Account</span></li>
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
            <div class="row">
                <div class="col-lg-4">
                    <!-- Profile Info -->
                    <div class="profile-info card">
                        <div class="card-header">
                            <h3 class="card-title">Profile Information</h3>
                        </div>
                        <div class="card-body">
                            <!--<div class="text-center mb-3">
                                <img src="../uploads/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Photo" class="profile-photo" style="width: 75%;">
                            </div>-->

                            <form method="post" action="editProfile.php?id=<?php echo $_GET['id'] ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control" required value="<?php if(isset($_POST['firstname'])) { echo $_POST['firstname']; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>
                                    <input type="text" id="middlename" name="middlename" class="form-control"  value="<?php if(isset($_POST['middlename'])) { echo $_POST['middlename']; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control" required value="<?php if(isset($_POST['lastname'])) { echo $_POST['lastname']; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" id="suffix" name="suffix" class="form-control" value="<?php if(isset($_POST['suffix'])) { echo $_POST['suffix']; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" id="contact_number" name="contact_number" class="form-control"   required value="<?php if(isset($_POST['contact_number'])) { echo $_POST['contact_number']; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control"  required value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } ?>" >
                                </div>
                                <button href="myAccount.php" type="submit" name="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <!-- Change Password Form -->
                    <div class="change-password card">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" required value="<?php echo $_SESSION['password']; ?>" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" toggle="#password">
                                                <i class="fa fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <a href="changePassword.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-primary">Change Password</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tab Area End -->

</main>

<!-- footer start -->
<?php require_once '../includes/footer.php'; ?>
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

<script>
    // Toggle password visibility
    $(document).ready(function() {
        $(".toggle-password").click(function() {
            $(this).toggleClass("active");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                input.attr("type", "password");
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        // Change cursor to pointer on toggle password icons
        $(".toggle-password").hover(function() {
            $(this).css('cursor', 'pointer');
        }, function() {
            $(this).css('cursor', 'auto');
        });
    });
</script>

</body>
</html>

