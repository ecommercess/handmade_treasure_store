<?php
    // Resume session here to fetch session values
    session_start();
    /*
        If user is not logged in then redirect to login page,
        this is to prevent users from accessing pages that require
        authentication such as the dashboard
    */
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'seller'){
        header('location: ../login/login-seller.php');
        exit(); // It's a good practice to call exit after header redirection
    }
    // If the above code is false then the HTML below will be displayed

    require_once '../tools/variables.php';
    $page_title = 'Seller Dashboard';
    $dashboard = 'active';

    require_once '../includes/header_admin.php';
?>
<body>
    <?php
        require_once '../includes/topnav_admin.php';
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
                require_once '../includes/sidebar.php';
            ?>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="mt-4">Welcome Seller</h1>
                <p>This is your dashboard where you can manage your shop, products, and more.</p>
            </div>
        </div>
    </div>
</body>
</html>
