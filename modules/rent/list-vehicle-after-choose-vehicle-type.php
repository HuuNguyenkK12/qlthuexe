<?php
    include_once('../../models/cookie.php');
    include_once('../../models/session.php');
    include_once('../../models/redirect.php');
    include_once('../../models/config.php');

    $db = new Database();
    if(isset($_GET['vehicleType']) && !empty($_GET['vehicleType'])){
        $vehicle_type = $_GET['vehicleType'];
        $list_vehicle = $db->select("select * from vehicle where vehicle_type='$vehicle_type' and vehicle_state=0");
        if(!empty($list_vehicle)){?>
            <option value="" class="text-black">Chọn xe</option>
            <?php
            foreach($list_vehicle as $vehicle){
            ?>
            <option value="<?php echo $vehicle['vehicle_id'];?>" class="text-black"><?php echo $vehicle['vehicle_name'];?></option>
        <?php
        }
    }
}
?>