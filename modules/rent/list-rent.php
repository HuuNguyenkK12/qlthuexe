<?php
    $sql = "SELECT distinct rent.rent_id, customer_name, customer_phone_number, verification_type, identity_id, user_id from rent join rent_detail on rent.rent_id=rent_detail.rent_id where finish_time is null";
    $db = new Database();
    $list_rent = $db->select($sql);
?>
<div class="row">
    <div class="col-4 col-xl-4">
        <div class="row" style="padding-left: 12px;">
            <div class="form-group col-8 p-0">
                <input type="text" class="form-control p-1" id="key-search">
            </div>
            <div class="col-4 p-l-1">
                <button type="button" class="btn btn-success" id="btn-search"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
    </div>
    <div class="col-4 col-xl-4">
        
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card text-black">
            <div class="card-header bg-info">
                <h3 class="card-title mt-2">Danh sách khách thuê xe</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-black" id="result-search">
                    <tr>
                        <th>Mã phiên thuê</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Loại xác minh</th>
                        <th>Số xác minh</th>
                        <th>Nhân viên cho thuê</th>
                        <th>Hành động</th>
                    </tr>
                    <?php
                        if(!empty($list_rent)){
                            foreach($list_rent as $rent){
                    ?>
                    <tr>
                        <td><?php echo $rent['rent_id'];?></td>
                        <td><?php echo $rent['customer_name'];?></td>
                        <td><?php echo $rent['customer_phone_number'];?></td>
                        <td><?php echo $rent['verification_type'];?></td>
                        <td><?php echo $rent['identity_id'];?></td>
                        <td>
                            <?php
                                $info_user = $db->select('select fullname from user where user_id='.$rent['user_id']);
                                echo $info_user[0]['fullname'];
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=add-rent-detail&rentID='.$rent['rent_id']);?>" class="btn btn-primary">Thuê thêm xe</a>
                            <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=rent-detail&rentID='.$rent['rent_id']);?>" class="btn btn-warning text-black">Chi tiết</a>
                           
                        </td>
                    </tr>
                    <?php 
                        }
                    }?>
                </table>
            </div>
            <div class="card-footer">
                <a href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=add-rent');?>" class="btn btn-success">Cho thuê</a>
                <a href="<?php echo $db->r->getUrl('qlthuexe/');?>" class="btn btn-success">Trở về</a>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    $(document).ready(function(){
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                $.ajax({
                    url: "modules/rent/search-rent.php",
                    type: "GET",
                    dataType: "text",
                    data: "key-search=" + $('#key-search').val(),
                    success: function(response){
                        $('#result-search').html(response);
                    },
                });
            }
        });
        $('#btn-search').click(function(){
            $.ajax({
                url: "modules/rent/search-rent.php",
                type: "GET",
                dataType: "text",
                data: "key-search=" + $('#key-search').val(),
                success: function(response){
                    $('#result-search').html(response);
                },
            });
        });
    });
</script>