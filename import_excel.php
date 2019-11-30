<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>
<!-- DataTables -->
<link rel="stylesheet" href="includes/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="includes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="importCtrl" class="card" id="dvForm">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>
        </div>
        <div class="card-body">

            <div class="col">

                <div class="form-group">
                    <span>เลือกไฟล์ : </span>
                    <input type="file" id="fileUploader" name="fileUploader" accept=".xls, .xlsx" />
                </div>
                <div class="form-group">
                    <table class="table table-hover" id="tbEmployee" style="width:100%">
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-inline">
                <div class="col" style="margin-bottom:10px;">
                    <button ng-click="saveData()" class="btn btn-success">บันทึก</button>
                    <button class="btn btn-danger">ยกเลิก</button>
                </div>
            </div>

        </div>
    </div>

    <?php include("includes/footer.php"); ?>
</body>

</html>
<script src="includes/plugins/datatables/jquery.dataTables.js"></script>
<script src="includes/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="includes/plugins/excel/jszip.js"></script>
<script src="includes/plugins/excel/xlsx.js"></script>
<script src="scripts/import_excel.js"></script>