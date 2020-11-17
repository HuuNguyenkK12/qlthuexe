<?php
    $db = new Database();
    $list_user = $db->select("select * from user");
?>
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title mt-2" style="color: black;">Danh sách tài khoản</h3>
            </div>
            <div class="card-body">
                <table class="table text-black table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Tên tài khoản</th>
                            <th>Họ & tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($list_user))
                                foreach($list_user as $user){
                        ?>
                        <tr>
                            <td><?php echo $user['user_id'];?></td>
                            <td><?php echo $user['username'];?></td>
                            <td><?php echo $user['fullname'];?></td>
                            <td><?php echo $user['phone_number'];?></td>
                            <td><?php echo $user['email'];?></td>
                            <td>
                                <a href="" class="btn btn-warning">Sửa</a>
                                <a href="" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php

                ?>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-success ">Thêm tài khoản</a>
                <a href="#" class="btn btn-success ">Trở về</a>
            </div>
        </div>
    </div>
</div>