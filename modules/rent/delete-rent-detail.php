<?php 
    $db = new Database();
    $rentID = "";
    $vehicleID = "";
    if(isset($_GET['rentID']) && isset($_GET['vehicleID'])){
        $rentID = $_GET['rentID'];
        $vehicleID = $_GET['vehicleID'];
    }
    $temp = $db->select("select * from rent where rent_id=$rentID");//lay thong tin phien thue xe
    $info_rent = $temp[0];

    $temp = $db->select("select * from vehicle where vehicle_id =$vehicleID");//lay thong tin xe duoc thue
    $info_vehicle = $temp[0];

    $temp = $db->select("select * from rent_detail where rent_id= $rentID and vehicle_id=$vehicleID");//lay chi tiet phien thue
    $info_rent_detail = $temp[0];

    if(isset($_POST['delete-rent-detail'])){
        $sql = "update rent_detail set finish_time= :finishTime where rent_id= :rentID and vehicle_id= :vehicleID";
        $data = [
            'finishTime' => date("Y-m-d H:i:s", time()),
            'rentID' => $rentID,
            'vehicleID' => $vehicleID
        ];
        if($db->update($sql, $data)){
            if($db->update("update vehicle set vehicle_state=0 where vehicle_id=$vehicleID")){
                $db->r->redirects($db->r->getUrl('qlthuexe/?module=rent&action=list-rent'));
            }
        }
    }
?>
<div class="row">
    <div class="col-12 col-xl-8 ">
        <form action="" method="POST">
            <div class="card text-black">
                <div class="card-header">
                    <h3 class="card-title mt-2">Xác nhận trả xe và thanh toán</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Khách hàng</label>
                            <span class="form-control text-black"><?php echo $info_rent['customer_name'];?></span>
                        </div>
                        <div class="col-3">
                            <label for="">Số điện thoại</label>
                            <span class="form-control text-black"><?php echo $info_rent['customer_phone_number'];?></span>
                        </div>
                        <div class="col-4">
                            <label for="">Loại xác minh</label>
                            <span class="form-control text-black"><?php echo $info_rent['verification_type'];?></span>
                        </div>
                        <div class="col-2">
                            <label for="">Số xác minh</label>
                            <span class="form-control text-black"><?php echo $info_rent['identity_id'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label for="" class="mt-2">Thuê xe</label>
                            <span class="form-control text-black"><?php echo $info_vehicle['vehicle_name'];?></span>
                        </div>
                        <div class="col-3">
                            <label for="" class="mt-2">Biển số</label>
                            <span class="form-control text-black"><?php echo $info_vehicle['license_plate'];?></span>
                        </div>
                        <div class="col-4">
                            <label for="" class="mt-2">Loại xe</label>
                            <span class="form-control text-black"><?php echo $info_vehicle['vehicle_type'];?></span>
                        </div>
                        <div class="col-2">
                            <label for="" class="mt-2">Chi phí thuê</label>
                            <span class="form-control text-black"><?php echo $info_vehicle['rent_expense'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label for="" class="mt-2">Thời gian bắt đầu</label>
                            <span class="form-control text-black">
                                <?php echo $info_rent_detail['start_time'];?></span>
                        </div>
                        <div class="col-3">
                            <label for="" class="mt-2">Thời gian kết thúc</label>
                            <span class="form-control text-black">
                                <?php echo date("Y-m-d H:i:s", time());?></span>
                        </div>
                        <div class="col-4">
                            <label for="" class="mt-2">Thời gian đã thuê</label>
                            <span class="form-control text-black">
                                <?php
                                    $rent_time = $db->convertSecond(time() - strtotime($info_rent_detail['start_time']));
                                    $rent_minute = floor((time()- strtotime($info_rent_detail['start_time'])) / 60);
                                    echo $rent_time['day'].' ngày '.$rent_time['hour'].' giờ '. $rent_time['minute']. ' phút '.$rent_time['second'].' giây';
                                ?>
                            </span>
                        </div>
                        <div class="col-2">
                            <label for="" class="mt-2"><b>Tổng tiền</b></label>
                            <span class="form-control text-black bd-black"><?php echo $db->formatMoney(floor(($info_vehicle['rent_expense'] / 60) * $rent_minute)) . ' đ';?></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" name="delete-rent-detail" value="Trả xe">
                    <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=rent-detail&rentID='.$rentID);?>" class="btn btn-warning">Trở về</a>
                </div>
            </div>
        </form>        
    </div>
</div>