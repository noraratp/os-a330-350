<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="includes/plugins/daterangepicker/daterangepicker.css">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="timeoffListCtrl" class="card" id="dvTimeoffList">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>

        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <select style="margin-top:10px;width:100px" id="selected" ng-change="searchTimeoff()" class="form-control"
                    ng-model="selectedYear">
                    <option ng-repeat="item in years" ng-selected="item == selectedYear" value="{{item}}">{{item}}
                    </option>
                </select>
                &nbsp;
            </div>

            <div class="col" style="margin-top:10px">
                <table class="table table-hover" id="tbTimeoff" style="width:100%">
                </table>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modalInput" tabindex="-1" role="dialog"
            aria-labelledby="modalInput" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Update Sick Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvBody">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-primary">
                                            <h3 class="card-title">ข้อมูลทั่วไป</h3>
                                        </div>
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle"
                                                    ng-src="{{selectedRecord.picture || 'file_upload/un_p.png'}}">

                                            </div>
                                            <h3 class="profile-username text-center">{{selectedRecord.name_en}}
                                                {{ selectedRecord.surname_en }}</h3>
                                            <p class="text-muted text-center"> {{ selectedRecord.employee_display}}</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            aria-valuenow="{{selectedRecord.timeoff_used}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{selectedRecord.timeoff_quota}}"
                                                            style="width: {{selectedRecord.timeoff_percent}}%">
                                                            <span class="sr-only">{{selectedRecord.timeoff_percent}} %
                                                                Timeoff</span>
                                                        </div>
                                                    </div>
                                                    <b>Sick Leave Availability</b> <a class="float-right">used
                                                        {{ selectedRecord.timeoff_used }} out of
                                                        {{selectedRecord.timeoff_quota}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Email</b> <a
                                                        class="float-right">{{ selectedRecord.gothaimail}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tel</b> <a class="float-right">{{selectedRecord.mobile}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-warning">
                                            <h3 class="card-title">ข้อมูลลา</h3>
                                        </div>
                                        <div class="card-body box-profile" style="margin-bottom:11px">

                                            <div class="form-group" style="margin-top:10px">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">วันลา : <span
                                                            class="required">*</span></span>&nbsp;

                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control float-right"
                                                            ng-model="selectedRecord.leave_date"
                                                            ng-class="selectedRecord.leave_date == '' || selectedRecord.leave_date == undefined ? 'required-element' : ''"
                                                            id="reservation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-top:10px">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">จำนวนวัน : </span>&nbsp;

                                                    <div class="input-group text-danger">
                                                        {{ selectedRecord.days || 0 }}
                                                    </div>
                                                    &nbsp; วัน
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Flight <span
                                                            class="required">*</span></span>&nbsp;
                                                    <input class="form-control" placeholder=""
                                                        ng-model="selectedRecord.flight"
                                                        ng-class="selectedRecord.flight == '' || selectedRecord.flight == undefined ? 'required-element' : ''">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span style="margin-bottom:10px"
                                                        class="font-weight-bold">ใบรับรองแพทย์ </span>&nbsp;
                                                    &nbsp;
                                                    <input type="file" file-input="file_upload" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Note </span>&nbsp;
                                                </div>
                                                <textarea ng-model="selectedRecord.note" style="resize:none" rows="3"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="onConfirmSave()">บันทึก</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-sm" id="modalConfirm" tabindex="-1" role="dialog"
            aria-labelledby="modalConfirm" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Save</h5>
                    </div>
                    <div class="modal-body" id="dvBody">
                        <div class="container">
                            <div class="row">
                                <span>ยืนยันการบันทึกข้อมูล ?</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="onSave()">บันทึก</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDelete"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger" style='color:white'>
                        ยืนยันการลบข้อมูล
                    </div>
                    <div class="modal-body text-center">
                        <h3 style="color:red">ยืนยันการลบข้อมูล ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" ng-click="onDelete()">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
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
<script src="includes/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/daterangepicker/daterangepicker.js"></script>
<script src="scripts/timeoff_list.js"></script>