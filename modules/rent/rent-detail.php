<?php
    $db = new Database();
    $rentID = "";
    if(isset($_GET['rentID'])){ //lay id thue 
        $rentID = $_GET['rentID'];
    }
    $temp = $db->select("select * from rent where rent_id=$rentID");// lay chi tiet phien thue
    $rent_detail = $temp[0]; 
    
    $vehicle_rent_list = $db->select("select * from rent_detail join vehicle on rent_detail.vehicle_id = vehicle.vehicle_id where rent_id=$rentID and finish_time is null"); //lay danh sach xe dang thue
   
?>
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card text-black">
            <div class="card-header">
                <h3 class="card-title mt-2 text-black">Chi tiết thuê xe</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <label for="">Khách hàng</label>
                        <span class="form-control text-black"><?php echo $rent_detail['customer_name'];?></span>
                        <hr class="bg-dark">
                    </div>
                    <div class="col-3">
                        <label for="">Số điện thoại</label>
                        <span class="form-control text-black"><?php echo $rent_detail['customer_phone_number'];?></span>
                        <hr class="bg-dark">
                    </div>
                    <div class="col-3">
                        <label for="">Loại xác minh</label>
                        <span class="form-control text-black"><?php echo $rent_detail['verification_type'];?></span>
                    </div>
                    <div class="col-3">
                        <label for="">Số xác minh</label>
                        <span class="form-control text-black"><?php echo $rent_detail['identity_id'];?></span>
                    </div>
                </div>
                <?php
                    if(!empty($vehicle_rent_list)){
                            $i = 0;
                            while($i < count($vehicle_rent_list)){
                            $row = $vehicle_rent_list[$i];
                ?>
                <div class="row">
                    <div class="col-3">
                        <label for="">Thuê xe</label>
                        <span class="form-control text-black"><?php echo $row['vehicle_name'];?></span>
                        <label for="" class="mt-2">Loại xe</label>
                        <span class="form-control text-black"><?php echo $row['vehicle_type'];?></span>

                        <label for="" class="mt-2">Thời gian bắt đầu</label>
                        <span class="form-control text-black"><?php echo $row['start_time'];?></span>
                    </div>
                    <div class="col-3">
                        <label for="">Biển số</label>
                        <span class="form-control text-black"><?php echo $row['license_plate'];?></span>
                        
                        <label for="" class="mt-2">Chi phí thuê</label>
                        <span class="form-control text-black"><?php echo $row['rent_expense'];?></span>

                        <label for="" class="mt-2">Thời gian đã thuê</label>
                        <span class="form-control text-black">
                            <?php
                                $rent_seconds = time() - strtotime($row['start_time']);
                                $rent_minutes = floor($rent_seconds / 60);
                                $rent_time = $db->convertSecond($rent_seconds);
                                echo $rent_time['day'].' ngày '.$rent_time['hour'].' giờ '. $rent_time['minute']. ' phút '.$rent_time['second'].' giây';
                            ?>
                        </span>
                    </div>
                    <div class="col-2">
                        <img src="<?php echo 'uploads/'.$row['image'];?>" alt="#" width="220" height="220" class="mt-2 border" style="padding: 2px;">
                    </div>
                    <div class="col-3">
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="" class="mt-2"><b>Tổng tiền dự tính: </b></label>
                        <span>
                            <?php
                                $money = $db->formatMoney(floor(($row['rent_expense'] / 60) * $rent_minutes)). ' đ';
                                echo $money;
                            ?>
                        </span><br>
                        <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=delete-rent-detail&rentID='.$rentID.'&vehicleID='.$row['vehicle_id']);?>" class="btn btn-primary">Trả xe</a>

                    </div>
                </div>
                <hr class="bg-dark">
                <?php
                    $i++;   
                    }
                }
                ?>
            </div>
            <div class="card-footer">
                <a href="" class="btn btn-success">Trả tất cả xe</a>
                <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=list-rent');?>" class="btn btn-info">Trở về</a>
            </div>
        </div>
    </div>
</div>
