<nav id="sidebarMenu" class="col-md-3 col-lg-3 col-xl-2 d-md-block background-color-green sidebar collapse">
    <div class="position-sticky h-100">
        <ul class="nav flex-column">
            <?php
                if($_SESSION['role'] == 'seller'){
            ?>
            <!--<li class="nav-item">
                <a href="../seller/dashboard.php" class="nav-link <?php echo $dashboard; ?>" title="Dashboard">
                    <i class='bx bx-grid-alt' ></i>
                    <span class="links-name">Dashboard</span>
                </a>
            </li>-->
            <li class="nav-item">
                <a href="../order" class="nav-link <?php echo $orders; ?>" title="Orders">
                    <i class='bx bx-cart'></i>
                    <span class="links-name">Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../product" class="nav-link <?php echo $products; ?>" title="Products">
                    <i class='bx bx-notepad'></i>
                    <span class="links-name">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../seller/profile.php" class="nav-link <?php echo $settings; ?>" title="Profile">
                    <i class='bx bx-cog'></i>
                    <span class="links-name">Profile</span>
                </a>
            </li>
            <?php
                }
            ?>
            <hr class="line">
            <li id="logout-link" class="nav-item">
                <a class="logout-link nav-link" href="../login/logout.php" title="Logout">
                    <i class='bx bx-log-out'></i>
                    <span class="links-name">Sign out</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div id="logout-dialog" class="dialog d-none" title="Logout">
    <p><span>Are you sure you want to logout?</span></p>
</div>