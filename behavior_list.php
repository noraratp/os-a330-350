<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="behaviorListCtrl" class="card" id="dvBehaviorList">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>

        </div>
        <div class="card-body">
            <div class="col" style="margin-top:10px">
                <table class="table table-hover" id="tbBehavior" style="width:100%">
                </table>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modalBehavior" role="dialog"
            aria-labelledby="modalInput" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Behavior</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvBodyBehavior">
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
                                            <p class="text-muted text-center"> {{ selectedRecord.rank}}
                                                {{selectedRecord.name_en}} {{selectedRecord.f_surname_en}}</p>
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
                                            <h3 class="card-title">ข้อมูลพฤติกรรม</h3>
                                        </div>
                                        <div class="card-body box-profile" style="margin-bottom:22px">

                                            <div class="form-group" style="margin-top:10px">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">วันที่ : <span
                                                            class="required">*</span></span>&nbsp;
                                                    <input class="form-control datepicker" placeholder="ปี/เดือน/วัน"
                                                        ng-model="selectedRecord.date"
                                                        ng-class="selectedRecord.date == '' || selectedRecord.date == undefined ? 'required-element' : ''"
                                                        data-date-format="yyyy/mm/dd">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">ประเภท : <span
                                                            class="required">*</span></span>&nbsp;
                                                </div>
                                                <select class="form-control" ng-model="selectedRecord.type" disabled
                                                    ng-class="selectedRecord.type == '' || selectedRecord.type == undefined ? 'required-element' : ''">
                                                    <option value="" disabled>-- ประเภท --</option>
                                                    <option value="good">ประพฤติกระทำความดี</option>
                                                    <option value="bad">ประพฤติกระทำความผิด</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Flight : </span>&nbsp;
                                                    <input class="form-control" placeholder=""
                                                        ng-model="selectedRecord.flight">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Note </span>&nbsp;
                                                </div>
                                                <textarea ng-model="selectedRecord.note" style="resize:none" rows="4"
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
                        <button type="button" class="btn btn-success" ng-click="onConfirmSaveBehavior()">บันทึก</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-sm" id="modalConfirmBehavior" role="dialog"
            aria-labelledby="modalConfirmBehavior" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                        <button type="button" class="btn btn-success" ng-click="onSaveBehavior()">บันทึก</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    </div>
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
<script src="scripts/behavior_list.js"></script>