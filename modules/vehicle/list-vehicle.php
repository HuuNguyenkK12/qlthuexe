<?php
    $sql = "";
    if(isset($_GET['vehicle-state'])){
        $sql = 'select * from vehicle where vehicle_state='.$_GET['vehicle-state']; 
    }
    else{
        $sql = "select * from vehicle";
    }
    $db = new Database();
    $list_vehicle = $db->select($sql);
?>
<div class="row">
    <div class="col-xl-12">
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card text-black">
            <div class="card-header bg-info">
                <h3 class="card-title mt-2">Danh sách tất cả xe</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-black">
                    <tr>
                        <th style="width: 70px;">Mã xe</th>
                        <th style="width: 130px;">Biển số</th>
                        <th style="width: 100px;">Loại xe</th>
                        <th style="width: 200px;">Tên xe</th>
                        <th style="width: 160px;">Trạng thái</th>
                        <th style="width: 350px;">Mô tả</th>
                        <th style="width: 100px;">Hình ảnh</th>
                        <th style="width: 140px;">Chi phí thuê</th>
                        <th style="width: 300px;">Hành động</th>
                    </tr>
                    <?php
                        if(!empty($list_vehicle))
                            foreach($list_vehicle as $vehicle){
                    ?>
                        <tr>
                            <td class="align-middle"><?php echo $vehicle['vehicle_id'];?></td>
                            <td class="align-middle"><?php echo $vehicle['license_plate'];?></td>
                            <td class="align-middle"><?php echo $vehicle['vehicle_type'];?></td>
                            <td class="align-middle"><?php echo $vehicle['vehicle_name'];?></td>
                            <td class="align-middle">
                                <?php 
                                    if($vehicle['vehicle_state'] == 1){
                                        echo '<span class="bg-success text-black form-control">Đang cho thuê</span>';
                                    }else if($vehicle['vehicle_state'] == 0){
                                        echo '<span class="bg-warning text-black form-control">Chưa cho thuê</span>';
                                    }else{
                                        echo '<span class="bg-danger">Bị hỏng</span>';
                                    }
                                
                                ?>
                            </td>
                            <td class="align-middle"><?php echo $vehicle['description'];?></td>
                            <td class="align-middle">
                                <img src="<?php echo 'uploads/'.$vehicle['image'];?>" alt="#" width="50" height="50">
                            </td>
                            <td class="align-middle"><?php echo floor($vehicle['rent_expense']).' vnđ/giờ';?></td>
                            <td class="align-middle">
                                <?php
                                    if($vehicle['vehicle_state'] == 1){
                                        $url = $db->r->getUrl('qlthuexe/?module=rent&action=list-rent');
                                        echo '<a href="'.$url.'" class="btn btn-primary text-white">Chi tiết</a>';
                                    }else if($vehicle['vehicle_state'] == 0){
                                        $url = $db->r->getUrl('qlthuexe/?module=vehicle&action=edit-vehicle&vehicleID='.$vehicle['vehicle_id']);
                                        echo '<a href="'.$db->r->getUrl('qlthuexe/?module=rent&action=add-rent').'" class="btn btn-success mr-1">Cho thuê</a>';
                                        echo '<a href="'.$url.'" class="btn btn-primary mr-1 ">Cập nhật</a>';
                                        echo '<a href="'.$url.'" class="btn btn-danger ">Xóa</a>';
                                    }
                                ?>
                                
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>
            <img src="" alt="">
            <div class="card-footer">
                <a href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=add-vehicle');?>" class="btn btn-success">Thêm mới xe</a>
                <a href="<?php echo $db->r->getUrl('qlthuexe/');?>" class="btn btn-success">Trở về</a>
            </div>
        </div>
    </div>
</div>
