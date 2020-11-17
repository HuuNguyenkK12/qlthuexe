<?php
    include_once('../../models/session.php');
    include_once('../../models/cookie.php');
    include_once('../../models/redirect.php');
    include_once('../../models/config.php');

    $key_search = "";
    if(isset($_GET['key-search'])){
        $key_search = $_GET['key-search'];
    }
    $sql = "SELECT distinct rent.rent_id, customer_name, customer_phone_number, verification_type, identity_id, user_id from rent join rent_detail on rent.rent_id=rent_detail.rent_id
            where finish_time is null and (customer_name like '%$key_search%' or customer_phone_number like '%$key_search%' or identity_id like '%$key_search%')";
    $db = new Database();
    $list_rent = $db->select($sql);
?>
<table class="table table-bordered table-striped text-black">
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
        $i = 0;
        if(empty($list_rent)){
            echo '<tr><td colspan="7"><h3 class="text-center" style="opacity: 0.3;">Không có dữ liệu <i class="far fa-frown-open"></i></h3></td></tr>';
        }else{
        while($i < count($list_rent)){
        $rent = $list_rent[$i];
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
        $i++; 
        }
    }
    ?>
</table>