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

// If add user is submitted
$user = new Users();
if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $user->id = $_GET['id'];
    $user->firstname = htmlentities($_POST['firstname']);
    $user->middlename = htmlentities($_POST['middlename']);
    $user->lastname = htmlentities($_POST['lastname']);
    $user->suffix = htmlentities($_POST['suffix']);
    $user->email = htmlentities($_POST['email']);
    $user->contact_number = $_POST['contact_number'];
    $user->address = $_POST['address'];

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
        header('location: profile.php');
        exit;
    }
    ob_end_flush(); // end output buffering and send output to browser
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
                                        <input type="text" id="firstname" name="firstname" class="form-control"  required value="<?php if(isset($_POST['firstname'])) { echo $_POST['firstname']; } ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="middlename">Middle Name</label>
                                        <input type="text" id="middlename" name="middlename" class="form-control" value="<?php if(isset($_POST['middlename'])) { echo $_POST['middlename']; } ?>" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control" required value="<?php if(isset($_POST['lastname'])) { echo $_POST['lastname']; } ?>" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" id="suffix" name="suffix" class="form-control" value="<?php if(isset($_POST['suffix'])) { echo $_POST['suffix']; } ?>" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number" class="form-control"required value="<?php if(isset($_POST['contact_number'])) { echo $_POST['contact_number']; } ?>" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" class="form-control" required value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } ?>" >
                                    </div>
                                    <button href="myAccount.php" type="submit" name="submit" class="btn btn-primary">Save</button>
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
                                <form method="post" action="change_password.php">
                                    <div class="form-group mb-3">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" id="current_password" name="current_password" class="form-control" required readonly>
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
</body>
</html>
