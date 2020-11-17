<?php
    $db = new Database();
    $list_vehicle_type = $db->select("select distinct vehicle_type from vehicle");
    $rent_id = "";
    $info_rent = "";
    if(isset($_GET['rentID'])){ //lay thong tin phien thue de update
        $rent_id = $_GET['rentID'];
        $temp = $db->select("select * from rent where rent_id=$rent_id");
        $info_rent = $temp[0];
    }
        if(isset($_POST['add-rent-detail'])){
        $sql = "insert into rent_detail values(:rentID, :vehicleID, :startTime, :finishTime)";
        $rent_detail = [
            'rentID' => $rent_id,
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
?>
<div class="row">
    <div class="col-12 col-xl-12">
        <form action="" method="POST">
            <div class="card text-black">
                <div class="card-header">
                    <h3 class="card-title mt-2">Cho thuê thêm xe</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Họ và tên</label>
                            <span class="form-control text-black"><?php echo $info_rent['customer_name'];?></span>
                        </div>
                        <div class="col-3">
                            <label for="">Số điện thoại</label>
                            <span class="form-control text-black"><?php echo $info_rent['customer_phone_number'];?></span>
                        </div>
                        <div class="col-3">
                            <label for="">Loại xác minh</label>
                            <span class="form-control text-black">
                                <?php
                                    if($info_rent['verification_type'] == "CCCD"){
                                        echo "Căn cước công dân";
                                    }else{
                                        echo "Chứng minh nhân dân";
                                    }
                                
                                ?>
                            </span>
                        </div>
                        <div class="col-3">
                            <label for="">Số xác minh</label>
                            <span class="form-control text-black"><?php echo $info_rent['identity_id'];?></span>
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
                    <input type="submit" class="btn btn-success" name="add-rent-detail" value="Cho thuê">
                    <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=list-rent')?>" class="btn btn-success">Trở về</a>
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