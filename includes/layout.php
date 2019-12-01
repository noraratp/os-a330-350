<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        <?include("function/version.php")?>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="includes/dist/img/AdminLTELogo.png" alt="Garage System" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">ระบบฐานข้อมูลลูกค้า</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="includes/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#"><h5 class="d-block"><? echo($_SESSION['login_user']->firstname . ' ' . $_SESSION['login_user']->lastname); ?></h5></a>
                    <div class="animated--grow-in">
                        <a class="" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="index.php"
                            class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                หน้าหลัก
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_list.php"
                            class="nav-link <?php if ($CURRENT_PAGE == "EmployeeList") {?>active<?php }?>">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                               พนักงาน
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="timeoff_list.php"
                            class="nav-link <?php if ($CURRENT_PAGE == "TimeoffList") {?>active<?php }?>">
                            <i class="nav-icon fas fa-bed"></i>
                            <p>
                                รายงานการลา
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="behavior_list.php"
                            class="nav-link <?php if ($CURRENT_PAGE == "BehaviorList") {?>active<?php }?>">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                รายงานการความประพฤติ
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                ลงทะเบียน
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="import_excel.php" class="nav-link <?php if ($CURRENT_PAGE == "Import") {?>active<?php }?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Import Employee</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-bottom:0px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?php print $PAGE_TITLE;?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><?php print $PAGE_TITLE;?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">