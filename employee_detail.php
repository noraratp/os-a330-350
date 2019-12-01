<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="empDetailCtrl" class="card" id="dvEmployeeDetail">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>

        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img ng-src="{{item.picture || 'file_upload/un_p.png'}}" alt=""
                                        class="img-circle img-fluid">
                                </div>

                                <h3 class="profile-username text-center">{{ item.rank}} {{item.name_en}}
                                    {{item.f_surname_en}} <a href="#" ng-click="onEditProfile()"><i class="fas fa-edit"></i></a></h3> 

                                <p class="text-muted text-center">{{item.name_en}} {{ item.surname_en }}</p>


                                <ul class="list-group list-group-unbordered mb-2">

                                    <li class="list-group-item">
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                aria-valuenow="{{item.timeoff_used}}" aria-valuemin="0"
                                                aria-valuemax="{{item.timeoff_quota}}"
                                                style="width: {{item.timeoff_percent}}%">
                                                <span class="sr-only">{{item.timeoff_percent}} %
                                                    Timeoff</span>
                                            </div>
                                        </div>
                                        <b>Sick Leave Availability</b> <a class="float-right">used
                                            {{ item.timeoff_used }} out of
                                            {{item.timeoff_quota}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <span class=""><i class="fas fa-lg fa-envelope"></i></span> Email:
                                        {{item.gothaimail}}
                                    </li>
                                    <li class="list-group-item">
                                        <span class=""><i class="fas fa-lg fa-phone"></i></span> Phone :
                                        {{item.mobile}}
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header p-2 bg-primary">
                                Sick Leave
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-hover" id="tbTimeoff" style="width:100%">
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-header p-2 bg-warning">
                                Behavior
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-hover" id="tbBehavior" style="width:100%">
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>
<script src="includes/plugins/datatables/jquery.dataTables.js"></script>
<script src="includes/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="scripts/employee_detail.js"></script>