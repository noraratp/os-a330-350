<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="myCtrl" class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>

        </div>
        <div class="card-body">
            <!-- Small boxes (Stat box) -->
            <div class="row" style="margin-top:10px">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sick Leave</h3>
                                <a href="timeoff_list.php">View Report</a>
                            </div>
                            <select style="margin-top:10px" id="selected" ng-change="getDashboardSummary()" class="form-inline" ng-model="selectedYear">
                                <option disabled value="">-----</option>
                                <option ng-repeat="item in years" ng-selected="{{item == selectedYear}}"
                                    value="{{item}}">{{item}}</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column text-danger">
                                    <span class="text-bold text-lg">{{sumFC || 0 | number}}</span>
                                    <span>Captains Leave</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right text-success">
                                    <span class="text-bold text-lg">{{sumFP || 0 | number}}</span>
                                    <span>Co-Pilot Leave</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="lineChart" style="height:250px; min-height:250px"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-danger"></i> Captain
                                </span>

                                <span>
                                    <i class="fas fa-square text-success"></i> Co-Pilot
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Export PDF </h3>

                        </div>
                        <div class="card-body p-0">
                            <table id="tbTimeoff" class="table table-striped">
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>
<script src="includes/plugins/datatables/jquery.dataTables.js"></script>

<script src="includes/plugins/datatables-export/dataTables.buttons.min.js"></script>
<script src="includes/plugins/datatables-export/jszip.min.js"></script>
<script src="includes/plugins/datatables-export/pdfmake.min.js"></script>
<script src="includes/plugins/datatables-export/vfs_fonts.js"></script>
<script src="includes/plugins/datatables-export/buttons.html5.min.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="includes/plugins/chart.js/Chart.min.js"></script>
<script src="scripts/index.js">
</script>