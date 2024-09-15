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
    require_once '../vendor/autoload.php';
    
    $config = HTMLPurifier_Config::createDefault();
    
    $config->set('Cache.DefinitionImpl', null);
    $config->set('HTML.AllowedElements', 'strong,em');
    $config->set('HTML.AllowedAttributes', []);
    
    $purifier = new HTMLPurifier($config);   

    $page_title = '';
    $phsi_events = 'active';

    require_once '../includes/header_admin.php';
?>

<body>

    <?php require_once '../includes/topnav_admin.php'; ?>

    <div class="container-fluid">
        <div class="row">

            <?php require_once '../includes/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-9 col-xl-10 p-md-4">
                <div class="w-100">
                    <h5 class="col-12 fw-bold mb-3 mt-3 mt-md-0">Products</h5>
                    <ul class="nav nav-tabs application">

                        <li class="nav-item active" id="li-product">
                            <a class="nav-link">Products<!--<span class="counter" id="counter-all">0</span>--></a>
                        </li>

                        <li class="nav-item" id="add-account">
                            <a class="nav-link" id="add-new">Add New</a>
                        </li>
                    </ul>
                    <div class="table-responsive py-3 table-container">

                    </div>
        </main>
    </div>
</div>
<script>
        function load(status){
            if(status == 'product'){
                $.ajax({
                    type: "GET",
                    url: 'product.php',
                    success: function(result)
                    {
                        $('div.table-responsive').html(result);
                        dataTable = $("#table-product").DataTable({
                            dom: 'Brtp',
                            responsive: true,
                            fixedHeader: true,
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: 'Excel',
                                    className: 'border-white'
                                },
                                {
                                    extend: 'pdf',
                                    text: 'PDF',
                                    className: 'border-white'
                                },
                                {
                                    extend: 'print',
                                    text: 'Print',
                                    className: 'border-white'
                                }
                            ],
                        });
                        dataTable.buttons().container().appendTo($('#MyButtons'));

                        $('input#keyword').on('input', function(e){
                            var status = $(this).val();
                            dataTable.columns([2]).search(status).draw();
                        });
                        $('select#product_category').on('change', function(e){
                            var status = $(this).val();
                            dataTable.columns([3]).search(status).draw();
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }  
                });
            } 
        }
        $(document).ready(function(){
            load('product');
            $('ul.application .nav-item').on('click', function(){
                $('ul.application .nav-item').removeClass('active');
                $(this).addClass('active');
            });

            $('#li-product').on('click', function(){
                load('product');
            });
        });
    </script>


<div id="edit-modal" class="modal"></div>

<div id="add-modal" class="admin-modal">
    <div class="admin-modal-content">
        <span class="close">&times;</span>
        <h3 class="admin-modal-title">Add Product</h3>
        <hr>
        <form id="addform" class="form-class" method="post" enctype="multipart/form-data">
        
            <!--Product Name-->
            <label for="product_name" class="form-label" style="font-weight: bold;">Product Name</label>
            <div class="input-group">
                <input class="form-control" type="text" name="product_name" id="product_name" required>
            </div>
            
            <!--Product Display-->
            <label for="file" style="font-weight: bold;">Upload Product Display</label>
            <div class="preview">
                <img id="file-preview">
            </div>
            
            <!--Product Display UPLOAD BUTTON-->
            <div class="input-group">
            <p style="font-size: 12px;color: red;font-style: italic;font-weight: lighter;">Max of 5mb. Accepted File Types: .jpg, .jpeg, .png</p>
                <input type="file" name="product_display" id="product_display" accept="image/*" onchange="showPreview(event)" required>
            </div>  

            <!--Description-->
            <label for="product_description" class="form-label" style="font-weight: bold;">Description</label>
            <div class="input-group">
                <textarea style="height: 300px; width: 100%;" class="form-control" type="text" name="product_description" id="product_description" rows="4" cols="50" required> </textarea>
            </div>

            <label for="product_category" style="font-weight: bold;">Product Category</label>
            <div class="input-group">
                <select id="product_category" name="product_category">
                    <option value="">--Select Category--</option>
                    <option value="Crocheted Item">Crocheted Item</option>
                    <option value="Satin Item">Satin Item</option>
                    <option value="Key Chain">Key Chain</option>
                    <option value="Phone Lace">Phone Lace</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <!--PRODUCT AVAIABLE STOCKS-->
            <label for="stocks" class="form-label" style="font-weight: bold;">Stocks</label>
            <div class="input-group">
                <input class="form-control" type="number" name="stocks" id="stocks" min="1"  required>
            </div>

            <!--PRODUCT PRICE-->
            <label for="price" class="form-label" style="font-weight: bold;">Price</label>
            <div class="input-group">
                <input class="form-control" type="price" name="price" id="price" required>
            </div>

            <div class="input-group">
                <input type="submit" id="submit" name="submit" value="Add Product" class="form-btn btn-primary">
                <input type="reset" id="btn-reset" name="btn-reset" hidden>
            </div>

        </form>

        <div id="loading-icon" style="display:none;">
            <img src="../images/content-images/loading.gif" alt="loading">
            <span>Loading...</span>
        </div>


        <style>
            #loading-icon {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                background-color: rgba(255, 255, 255, 0.5);
                padding: 10px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #loading-icon img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            #loading-icon span {
                font-size: 16px;
                font-weight: bold;
            }
        </style>

    </div>
</div>
</section>

<style>
    .form-label {
        display: block;
        margin-top: 1em;
    }

    .input-group {
        margin-bottom: 1em;
    }

    .preview {
        margin-bottom: 1em;
    }

    .preview img {
        max-width: 100%;
        max-height: 20em;
    }

    .submit-button {
        background-color: #4CAF50;
        color: white;
        padding: 0.5em 1em;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: #3e8e41;
    }

    .form-control {
        width: 100%;
        padding: 0.5em;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>

</body>
</html>

