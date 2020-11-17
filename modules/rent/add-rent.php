<?php
    $db = new Database();
    $list_vehicle_type = $db->select("select distinct vehicle_type from vehicle");
    $username = "";
    $user_id = "";

    if(isset($_SESSION['user-token'])){
        $username = $_SESSION['user-token'];
    }else{
        if(isset($_COOKIE['user-token'])){
            $username = $_COOKIE['user-token'];
        }
    }
    if(!empty($username)){
        $temp = $db->select("select user_id from user where username='$username'");
        $user_id = $temp[0]['user_id'];
    }
    if(isset($_POST['add-rent'])){
        $sql = "insert into rent values(:rentID, :identityID, :verificationType, :customerName, :customerPhoneNumber, :rentDate, :userID)";
        $data = [
            'rentID' => 0,
            'identityID' => $_POST['identity-id'],
            'verificationType' => $_POST['verification-type'],
            'customerName' => $_POST['customer-name'],
            'customerPhoneNumber' => $_POST['customer-phone-number'],
            'rentDate' => date("Y-m-d", time()),
            'userID' => $user_id
        ];
        if($db->insert($sql, $data)){
            $identity_id = $data['identityID'];
            $temp = $db->select("select rent_id from rent where identity_id='$identity_id'");
            $sql = "insert into rent_detail values(:rentID, :vehicleID, :startTime, :finishTime)";
            $rent_detail = [
                'rentID' => $temp[0]['rent_id'],
                'vehicleID' => $_POST['vehicle-name'],
                'startTime' => $_POST['start-time'],
                'finishTime' => null,
            ];
            if($db->insert($sql, $rent_detail)){
                $vehicle_id = $rent_detail['vehicleID'];
                if($db->update("update vehicle set vehicle_state=1 where vehicle_id='$vehicle_id'")){
                    $db->r->redirects($db->r->getUrl('qlthuexe/?module=rent&action=list-rent'));
                }
            }
            
        }
    }

?>
<div class="row">
    <div class="col-12 col-xl-12">
        <form action="" method="POST">
            <div class="card text-black">
                <div class="card-header">
                    <h3 class="card-title mt-2">Cho thuê</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Họ và tên</label>
                            <input type="text" class="form-control text-black" name="customer-name">
                        </div>
                        <div class="col-3">
                            <label for="">Số điện thoại</label>
                            <input type="text" class="form-control text-black" name="customer-phone-number">
                        </div>
                        <div class="col-3">
                            <label for="">Loại xác minh</label>
                            <select name="verification-type" class="form-control text-black" required>
                                <option value="" class="text-black">Chọn loại xác minh</option>
                                <option value="CMND" class="text-black">Chứng minh nhân dân</option>
                                <option value="CCCD" class="text-black">Căn cước công dân</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Số xác minh</label>
                            <input type="text" class="form-control text-black" name="identity-id" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3">
                            <label for="">Loại xe</label>
                            <select id="choose-vehicle-type" name="" class="form-control text-black">
                                <option value="" class="text-black" selected>Chọn loại xe</option>
                                <?php
                                    if(!empty($list_vehicle_type)){
                                        foreach($list_vehicle_type as $vehicle_type){
                                ?>
                                <option value="<?php echo $vehicle_type['vehicle_type'];?>" class="text-black"><?php echo $vehicle_type['vehicle_type'];?></option>
                                <?php
                                    } 
                                }
                                ?>
                            </select>
                            <label for="" class="mt-2">Thuê xe</label>
                            <select name="vehicle-name" id="choose-vehicle" class="form-control text-black">
                            </select>

                            <label for="" class="mt-2">Thời gian bắt đầu</label>
                            <input type="text" class="form-control text-black" name="start-time" value="<?php echo date("Y-m-d H:i:s", time());?>">
                        </div>
                        <div class="col-3">
                            <label for="">Biển số</label>
                            <input type="text" class="form-control text-black" name="license-plate" id="license-plate" disabled>

                            <label for="" class="mt-2">Chi phí thuê (nghìn đồng / giờ)</label>
                            <input type="text" class="form-control text-black" name="rent-expense" id="rent-expense" disabled>
                        </div>
                        <div class="col-3">
                            <img src="" alt="Chưa chọn xe" id="vehicle-image" width="240" height="240" class="border">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" name="add-rent" value="Cho thuê">
                    <a href="<?php echo $db->r->getUrl('qlthuexe/')?>" class="btn btn-success">Trở về</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script language="javascript">
    $(document).ready(function(){
        $('#choose-vehicle-type').change(function(){
            var vehicleType = $('#choose-vehicle-type').val();
            $.ajax({
                url: "modules/rent/list-vehicle-after-choose-vehicle-type.php",
                type: "get",
                dataType: "text",
                data: "vehicleType=" + vehicleType,
                success: function(response){
                    $('#choose-vehicle').html(response);
                }
            });
        });
        //---
        $('#choose-vehicle').change(function(){
            var vehicleID = $('#choose-vehicle').val();
            $.ajax({
                url: "modules/rent/info-vehicle.php",
                type: "get",
                dataType: "json",
                data: "vehicleID=" + vehicleID,
                success:function(response){
                    $('#vehicle-type').val(response.vehicle_type);
                    $('#license-plate').val(response.license_plate);
                    $('#rent-expense').val(Math.floor(response.rent_expense));
                    $('#vehicle-image').attr("src", 'uploads/'+response.image);
                }
            });
        });
    });
</script>