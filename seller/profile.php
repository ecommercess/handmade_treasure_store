<?php
// Resume session to fetch session values
session_start();

/*
    If user is not logged in, redirect to login page.
    This prevents users from accessing pages that require authentication, such as the dashboard.
*/
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'seller') {
    header('location: ../login/login-seller.php');
}

// If the above code is false, the HTML below will be displayed
require_once '../tools/variables.php';
$page_title = 'Shop Name | Seller Dashboard';
$settings = 'active';

require_once '../includes/header_admin.php';
require_once '../classes/user.class.php';




?>
<body>
    <?php require_once '../includes/topnav_admin.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once '../includes/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-9 col-xl-10 p-md-4 mt-3 mt-md-0">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6">
                        <!-- Profile Info -->
                        <div class="profile-info card shadow-sm">
                            <div class="card-header text-black">
                                <h3 class="card-title">Profile Information</h3>
                            </div>
                            <div class="card-body">
                                <!--<div class="text-center mb-3">
                                    <img src="../uploads/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Photo" class="profile-photo" style="width: 75%;">
                                </div>-->
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group mb-3">
                                        <label for="firstname">First Name</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $_SESSION['firstname']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="middlename">Middle Name</label>
                                        <input type="text" id="middlename" name="middlename" class="form-control" value="<?php echo $_SESSION['middlename']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $_SESSION['lastname']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" id="suffix" name="suffix" class="form-control" value="<?php echo $_SESSION['suffix']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="<?php echo $_SESSION['contact_number']; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $_SESSION['address']; ?>" readonly>
                                    </div>
                                    <a href="editProfile.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-primary">Update Profile</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Change Password Form -->
                        <div class="change-password card shadow-sm">
                            <div class="card-header text-black">
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <div class="form-group mb-3">
                                        <label for="current_password">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" id="current_password" name="current_password" class="form-control" required value="<?php echo $_SESSION['password']; ?>" readonly>
                                            <div class="input-group-text toggle-password" toggle="#current_password">
                                                <i class="fa fa-eye-slash"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="changePassword.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-primary">Change Password</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
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
