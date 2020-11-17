<?php
    $db= new Database();
    $vehicleID = isset($_GET['vehicleID']) ? $_GET['vehicleID'] : "";
    $sql = "select * from vehicle where vehicle_id=$vehicleID";
    $temp = $db->select($sql);
    $vehicle = $temp[0];

    if(isset($_POST['edit-vehicle'])){
        $sql = "update vehicle set license_plate=:licensePlate, vehicle_type=:vehicleType, vehicle_name=:vehicleName, vehicle_state=:vehicleState, description=:description, rent_expense=:rentExpense, image=:image where vehicle_id=:vehicleID";
        $data = [
            'licensePlate' => $_POST['license-plate'],
            'vehicleType' => $_POST['vehicle-type'],
            'vehicleName' => $_POST['vehicle-name'],
            'vehicleState' => $_POST['vehicle-state'],
            'description' => $_POST['description'],
            'rentExpense' => $_POST['rent-expense'],
            'image' => isset($_FILES['vehicle-img']) ? $_FILES['vehicle-img']['name'] : $vehicle['image'],
            'vehicleID' => $vehicleID
        ];
        // echo "<pre>";
        //     var_dump($data);
        // echo "</pre>";
        if(isset($_FILES['vehicle-img'])){
            $file = [
                'name' => $_FILES['vehicle-img']['name'],
                'tmp_name' => $_FILES['vehicle-img']['tmp_name'],
                'size' =>$_FILES['vehicle-img']['size']
            ];
            if($db->uploadImage($file)){
                if($db->insert($sql, $data)){
                    $db->r->redirects($db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle'));
                }else{
                        echo "<script>alert('Cập nhật thông tin xe không thành công, kiểm tra lại dữ lịêu nhập vào.')</script>";
                }
            }else{
                echo "<script>alert('Cập nhật thông tin xe không thành công, kiểm tra lại hình ảnh.')</script>";
            }
        }else{
            if($db->update($sql, $data)){
                $db->r->redirects($db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle'));
            }
        }
    }
?>
<div class="row">
    <div class="col-md-8">
        <form action="" method="post" enctype="multipart/form-data" class="">
            <div class="card text-black">
                <div class="card-header bg-info">
                    <h3 class="card-title mt-2">Cập nhật thông tin xe</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="row">
                                <div class="form-group col-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="">Biển số xe</label>
                                            <input type="text" class="form-control" name="license-plate" value="<?php echo $vehicle['license_plate'];?>" required>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">Loại xe</label>
                                            <input type="text" class="form-control" name="vehicle-type" value="<?php echo $vehicle['vehicle_type'];?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-xl-12">
                                    <label for="">Tên xe</label>
                                    <input type="text" class="form-control" name="vehicle-name" value="<?php echo $vehicle['vehicle_name'];?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-xl-12">
                                    <label for="">Mô tả</label>
                                    <textarea name="description" id="" class="form-control" style="height: 100px;"><?php echo $vehicle['description'];?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-xl-12">
                                    <label for="">Trạng thái</label>
                                    <div class="row">
                                        <div class="col-xl-6 pt-2">
                                            <input type="radio" name="vehicle-state" value="0" required checked>
                                            <label for="">Chưa cho thuê</label>
                                        </div>
                                        <div class="col-xl-6 pt-2">
                                            <input type="radio" name="vehicle-state" value="1" required>
                                            <label for="">Đang cho thuê</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="">Chi phí thuê</label>
                                            <input type="text" class="form-control" name="rent-expense" value="<?php echo floor($vehicle['rent_expense']);?>" required>
                                        </div>
                                        <div class="col-xl-6">
                                            <!-- <button type="button" class="btn btn-info">Thay đổi hình ảnh</button>
                                            <label for="">Hình ảnh</label>
                                            <input type="file" class="" name="vehicle-img"> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-xl-6">
                                    <script language="javascript">
                                        $(document).ready(function(){
                                            $('#change-img').click(function(){
                                                $('#vehicle-img').html('<label for="" class="">Hình ảnh</label><input type="file" class="" name="vehicle-img">');
                                                $('#change-img').css("display", "none");
                                            });
                                        });
                                    </script>    
                                    <button type="button" class="btn btn-info" id="change-img">Thay đổi hình ảnh</button>
                                    <div id="vehicle-img"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group border text-center">
                                <img src="<?php echo 'uploads/'.$vehicle['image'];?>" alt="#" width="350" height="350">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" name="edit-vehicle" value="Lưu thay đổi">
                    <a href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle');?>" class="btn btn-success">Trở về</a>
                </div>
            </div>
        </form>
    </div>
</div>