<?php
    $db = new Database();
    if(isset($_POST['add-vehicle'])){
        $sql = "insert into vehicle values(:vehicleID, :licensePlate, :vehicleType, :vehicleName, :vehicleState, :description, :rentExpense, :image)";
        $data = [
            'vehicleID' => 0,   
            'licensePlate' => $_POST['license-plate'],
            'vehicleType' => $_POST['vehicle-type'],
            'vehicleName' => $_POST['vehicle-name'],
            'vehicleState' => 0,
            'description' => $_POST['description'],
            'rentExpense' => $_POST['rent-expense'],
            'image' => $_FILES['vehicle-img']['name']
        ];
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
                        echo "<script>alert('Thêm mới xe không thành công, kiểm tra lại dữ lịêu nhập vào.')</script>";
                }
            }else{
                echo "<script>alert('Thêm mới xe không thành công, kiểm tra lại hình ảnh.')</script>";
            }
        }
    }
?>
<div class="row">
    <div class="col-md-8">
        <form action="" method="post" enctype="multipart/form-data" class="">
            <div class="card text-black">
                <div class="card-header bg-info">
                    <h3 class="card-title mt-2">Thêm mới xe</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-xl-6">
                            <div class="row">
                                <div class="col-xl-6">
                                    <label for="">Biển số xe</label>
                                    <input type="text" class="form-control" name="license-plate" required>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">Loại xe</label>
                                    <input type="text" class="form-control" name="vehicle-type" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-xl-6">
                            <label for="">Tên xe</label>
                            <input type="text" class="form-control" name="vehicle-name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-xl-6">
                            <label for="">Mô tả</label>
                            <textarea name="description" id="" class="form-control" style="height: 100px;"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-xl-6">
                            <div class="row">
                                <div class="col-xl-6">
                                    <label for="">Chi phí thuê</label>
                                    <input type="text" class="form-control" name="rent-expense" required>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">Hình ảnh</label>
                                    <input type="file" class="" name="vehicle-img" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" name="add-vehicle" value="Thêm xe">
                    <a href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle');?>" class="btn btn-success">Trở về</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- <div class="row">
        <div class="input-group col-8">
            <div class="input-group-prepend">
                <span class="input-group-text">Trạng thái:</span>
                <div class="input-group-text">
                    <input type="radio" name="" value="Chưa cho thuê" checked required>
                </div>
                <span class="input-group-text bg-warning text-white">Chưa cho thuê</span>
                <div class="input-group-text">
                    <input type="radio" name="" value="Bị hỏng" required>
                </div>
                <span class="input-group-text bg-danger text-white">Bị hỏng</span>
            </div>
        </div>
    </div> -->