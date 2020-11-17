<?php
    $db = new Database();
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-motorcycle"></i>
        </div>
        <div class="sidebar-brand-text mx-3">M-BIKE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang quản lý thuê xe</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>

    <li class="nav-item">
        <a style="cursor: pointer;" class="nav-link collapsed" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
            <i class="fas fa-user"></i>
            <span>Quản lý tài khoản</span>
        </a>
        <div id="collapseAccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Thành phần:</h6>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=account&action=add-account');?>">Thêm mới tài khoản</a>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=account&action=list-account');?>">Danh sách tài khoản</a>
            </div>
        </div>
    </li>
    
    <li class="nav-item">
        <a style="cursor: pointer;" class="nav-link collapsed" data-toggle="collapse" data-target="#collapseVehicle" aria-expanded="true" aria-controls="collapseVehicle">
            <i class="fas fa-biking"></i>
            <span>Quản lý xe</span>
        </a>
        <div id="collapseVehicle" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Thành phần:</h6>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle');?>">Tất cả xe</a>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle&vehicle-state=1');?>">Xe đang cho thuê</a>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=vehicle&action=list-vehicle&vehicle-state=0');?>">Xe trống</a>
                <a class="collapse-item" href="">Xe hỏng</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a style="cursor: pointer;" class="nav-link collapsed" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Quản lý thuê xe</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Thành phần:</h6>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=list-rent');?>">Danh sách khách thuê</a>
                <a class="collapse-item" href="<?php echo $db->r->getUrl('qlthuexe/?module=rent&action=add-rent');?>">Cho thuê</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>