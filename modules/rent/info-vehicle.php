<?php
    include_once('../../models/cookie.php');
    include_once('../../models/session.php');
    include_once('../../models/redirect.php');
    include_once('../../models/config.php');

    $db = new Database();
    if(isset($_GET['vehicleID']) && !empty($_GET['vehicleID'])){
        $vehicleID = $_GET['vehicleID'];
        $sql = "select * from vehicle where vehicle_id=$vehicleID";
        $temp = $db->select($sql);
        $vehicle = $temp[0];
        echo json_encode($vehicle);
        exit();
    }

?>