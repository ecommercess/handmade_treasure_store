<?php

    //resume session here to fetch session values
    session_start();
    
    /*
        if user is not login then redirect to login page,
        this is to prevent users from accessing pages that requires
        authentication such as the dashboard
    */
    if (!isset($_SESSION['logged-in'])){
        header('location: ../home.php');
    }
    //if the above code is false then html below will be displayed

    require_once '../tools/variables.php';
    $page_title = 'Orders';
    $application = 'active';

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

            <main class="col-md-9 ms-sm-auto col-lg-9 col-xl-10 p-md-4">
                <div class="w-100">
                    <h5 class="col-12 fw-bold mb-3 mt-3 mt-md-0">Orders</h5>
                    <ul class="nav nav-tabs application">
                        <li class="nav-item active" id="li-pending">
                            <a class="nav-link">Pending</a>
                        </li>
                        <li class="nav-item" id="li-confirmed">
                            <a class="nav-link">Confirmed</a>
                        </li>
                        <li class="nav-item" id="li-intransit">
                            <a class="nav-link">In Transit</a>
                        </li>
                        <li class="nav-item" id="li-completed">
                            <a class="nav-link">Completed </a>
                        </li>
                        <!--<li class="nav-item" id="li-cancelled">
                            <a class="nav-link">Cancelled </a>
                        </li>-->
                    </ul>
                    <div class="table-responsive py-3 table-container">

                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function load(status){
            if(status == 'pending'){
                $.ajax({
                    type: "GET",
                    url: 'pending.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-pending").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: []
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            }else if(status == 'confirmed'){
                $.ajax({
                    type: "GET",
                    url: 'confirmed.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-confirmed").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: []
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            }else if(status == 'intransit'){
                $.ajax({
                    type: "GET",
                    url: 'intransit.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-intransit").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: []
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            }else if(status == 'completed'){
                $.ajax({
                    type: "GET",
                    url: 'completed.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-completed").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: []
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            }else if(status == 'cancelled'){
                $.ajax({
                    type: "GET",
                    url: 'cancelled.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-cancelled").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: []
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            }
        }
        $(document).ready(function(){
            load('pending');
            $('ul.application .nav-item').on('click', function(){
                $('ul.application .nav-item').removeClass('active');
                $(this).addClass('active');
            });

            $('#li-pending').on('click', function(){
                load('pending');
            });

            $('#li-confirmed').on('click', function(){
                load('confirmed');
            });

            $('#li-intransit').on('click', function(){
                load('intransit');
            });

            $('#li-completed').on('click', function(){
                load('completed');
            });

            $('#li-cancelled').on('click', function(){
                load('cancelled');
            });

            $('#comments').on('change', function(){
                if ($(this).is(":checked")) {
                    $('div.comments').show();
                    $('#pending-submit').text("Decline Application")
                }else{
                    $('div.comments').hide();
                    $('#pending-submit').text("Accept Application")
                }
            });

            $('#Confirmed').on('click', function(){
                $('div.documents').show();
            });

            $('#Withdrawn').on('click', function(){
                $('div.documents').hide();
            });

            $('#Waiting-Rejected').on('click', function(){
                $('#waiting-submit').text("Reject Application")
            });

            $('#ranking-comments').on('change', function(){
                if ($(this).is(":checked")) {
                    $('div.ranking-comments').show();
                }else{
                    $('div.ranking-comments').hide();
                }
            });

            $('#waiting-comments').on('change', function(){
                if ($(this).is(":checked")) {
                    $('div.waiting-comments').show();
                }else{
                    $('div.waiting-comments').hide();
                }
            });

            $('#qualified-comments').on('change', function(){
                if ($(this).is(":checked")) {
                    $('div.qualified-comments').show();
                }else{
                    $('div.qualified-comments').hide();
                }
            });

            $('div.photo-container').lightGallery({
                thumbnail: false,
                animateThumb: false,
                showThumbByDefault: false
            }); 

        });
    </script>
</body>
</html>