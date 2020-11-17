<?php
    include_once('models/session.php');
    include_once('models/cookie.php');
    include_once('models/redirect.php');
    include_once('models/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý thuê xe.</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/css/">
    <link href="assets/css/all.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"></script>
    <style>
        .text-black{
            color: black;
        }
        .h-100{
            height: 66px;
        }
        .align-middle{
            padding: 2px;
        }
        .bd-black{
            border: 1px solid black;
        }
</style>
</head>
<?php
    $module = isset($_GET['module']) ? $_GET['module'] : "common";
    $action = isset($_GET['action']) ? $_GET['action'] : "home";
    $path = "";

    if(!isset($_SESSION['user-token'])){ //Kiem tra nguoi dung da login chua ? Neu chua thi chuyen den trang login.php
        $module = "common";
        $action = "login";
    }
    if(isset($_COOKIE['user-token'])){ //Remember me
        $module = isset($_GET['module']) ? $_GET['module'] : "common";
        $action = isset($_GET['action']) ? $_GET['action'] : "home";
    }
    
    if($module === "common" && $action === "login"){
        $path = 'modules/'.$module.'/'.$action.'.php';
        include_once($path);
    }else{
        $path = 'modules/'.$module.'/'.$action.'.php';
    

?>
<body id="page-top">
    <div id="wrapper">
        <?php include_once('layouts/sidebar.php');?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once('layouts/header.php');?>
                <div class="container-fluid">
                    <?php
                        include_once('layouts/statistical.php');
                        include_once($path); 
                    ?>
                </div>
            </div>
            <?php include_once('layouts/footer.php');?>
        </div>
    </div>
<?php
    }
?>     
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    
</body>
</html>