<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="includes/plugins/daterangepicker/daterangepicker.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="empListCtrl" class="card" id="dvSickleave">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>

        </div>
        <div class="card card-solid">
            <div class="col-12" style="margin-top:10px;">
                <div class="form-inline">
                    <label style="margin-left:15px">ค้นหา : </label> &nbsp;
                    <input type="search" class="form-control" ng-model="filterText" />
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="row d-flex align-items-stretch">
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch"
                        dir-paginate="item in employeeList | filter:filterText | itemsPerPage:9">
                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0">
                                {{ item.rank}} {{item.name_en}} {{item.f_surname_en}}
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b> {{item.name_en}} {{ item.surname_en }}</b></h2>
                                        <p class="text-muted text-sm"><b>Sick Leave Availability : </b>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    aria-valuenow="{{item.timeoff_used}}" aria-valuemin="0"
                                                    aria-valuemax="{{item.timeoff_quota}}"
                                                    style="width: {{item.timeoff_percent}}%">
                                                    <span class="sr-only">{{item.timeoff_percent}} % Timeoff</span>
                                                </div>
                                            </div>
                                            <span class="ิtext-primary">used {{ item.timeoff_used }} out of
                                                {{item.timeoff_quota}}</span>
                                        </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-envelope"></i></span> Email:
                                                {{item.gothaimail}}</li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> Phone : {{item.mobile}}
                                            </li>
                                            <li class="small"><span class="fa-li"></span> A330 :
                                                {{item.a330 == '1' ? 'Yes' :'No'}}</li>
                                            <li class="small"><span class="fa-li"></span> A350 :
                                                {{item.a350  == '1' ? 'Yes' :'No'}}
                                            </li>
                                            <li class="small"><span class="fa-li"></span> A350 Cruise :
                                                {{item.a350cruise == '1' ? 'Yes' :'No'}}</li>
                                            <li ng-if="item.sub_rank == 'FC'" class="small"><span class="fa-li"></span>
                                                RH Qualified : {{item.rh_qualified == '1' ? 'Yes' :'No'}}
                                            </li>
                                            <li ng-if="item.sub_rank == 'FP'" class="small"><span class="fa-li"></span>
                                                LH Qualified : {{item.lh_qualified == '1' ? 'Yes' :'No'}}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img ng-src="{{item.picture || 'file_upload/un_p.png'}}" alt=""
                                            class="img-circle img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="#" class="btn btn-sm bg-warning" ng-click="onBehevior(item.id,'good')">
                                        <i class="far fa-grin"></i> Behavior
                                    </a>
                                    <a href="#" class="btn btn-sm bg-teal" ng-click="onSickLeave(item.id)">
                                        <i class="fas fa-calendar"></i> Sick Leave
                                    </a>
                                    <a href="employee_detail.php?id={{item.id}}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-user"></i> Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <dir-pagination-controls max-size="9" direction-links="true" boundary-links="true">
                </dir-pagination-controls>
            </div>
            <!-- /.card-footer -->
        </div>

        <div class="modal fade bd-example-modal-lg" id="modalInput" tabindex="-1" role="dialog"
            aria-labelledby="modalInput" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Sick Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvBodySickLeave">
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
                                                    ng-src="{{selectedEmployee.picture || 'file_upload/un_p.png'}}">

                                            </div>
                                            <h3 class="profile-username text-center">{{selectedEmployee.name_en}}
                                                {{ selectedEmployee.surname_en }}</h3>
                                            <p class="text-muted text-center"> {{ selectedEmployee.rank}}
                                                {{selectedEmployee.name_en}} {{selectedEmployee.f_surname_en}}</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            aria-valuenow="{{selectedEmployee.timeoff_used}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{selectedEmployee.timeoff_quota}}"
                                                            style="width: {{selectedEmployee.timeoff_percent}}%">
                                                            <span class="sr-only">{{selectedEmployee.timeoff_percent}} %
                                                                Timeoff</span>
                                                        </div>
                                                    </div>
                                                    <b>Sick Leave Availability</b> <a class="float-right">used
                                                        {{ selectedEmployee.timeoff_used }} out of
                                                        {{selectedEmployee.timeoff_quota}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Email</b> <a
                                                        class="float-right">{{ selectedEmployee.gothaimail}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tel</b> <a class="float-right">{{selectedEmployee.mobile}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A330
                                                    <a class="float-right">
                                                        {{selectedEmployee.a330 == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A350
                                                    <a class="float-right">
                                                        {{selectedEmployee.a350 == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A350 Cruise
                                                    <a class="float-right">
                                                        {{selectedEmployee.a350cruise == '1' ? 'Yes' :'No'}}</a></li>
                                                <li ng-if="selectedEmployee.sub_rank == 'FC'" class="list-group-item">
                                                    <span class="fa-li"></span>
                                                    RH Qualified
                                                    <a class="float-right">
                                                        {{selectedEmployee.rh_qualified == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li ng-if="selectedEmployee.sub_rank == 'FP'" class="list-group-item">
                                                    <span class="fa-li"></span>
                                                    LH Qualified
                                                    <a class="float-right">
                                                        {{selectedEmployee.lh_qualified == '1' ? 'Yes' :'No'}}</a>
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
                                                            ng-model="selectedEmployee.leave_date"
                                                            ng-class="selectedEmployee.leave_date == '' || selectedEmployee.leave_date == undefined ? 'required-element' : ''"
                                                            id="reservation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-top:10px">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">จำนวนวัน : </span>&nbsp;

                                                    <div class="input-group text-danger">
                                                        {{ selectedEmployee.leave_days || 0 }}
                                                    </div>
                                                    &nbsp; วัน
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Flight <span
                                                            class="required">*</span></span>&nbsp;
                                                    <input class="form-control" placeholder=""
                                                        ng-model="selectedEmployee.flight"
                                                        ng-class="selectedEmployee.flight == '' || selectedEmployee.flight == undefined ? 'required-element' : ''">
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
                                                <textarea ng-model="selectedEmployee.note" style="resize:none" rows="3"
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
        <div class="modal fade bd-example-modal-sm" id="modalConfirm" role="dialog" aria-labelledby="modalConfirm"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
        <div class="modal fade bd-example-modal-lg" id="modalBehavior" role="dialog" aria-labelledby="modalInput"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                                                    ng-src="{{selectedEmployee.picture || 'file_upload/un_p.png'}}">

                                            </div>
                                            <h3 class="profile-username text-center">{{selectedEmployee.name_en}}
                                                {{ selectedEmployee.surname_en }}</h3>
                                            <p class="text-muted text-center"> {{ selectedEmployee.rank}}
                                                {{selectedEmployee.name_en}} {{selectedEmployee.f_surname_en}}</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <div class="progress mb-3">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            aria-valuenow="{{selectedEmployee.timeoff_used}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{selectedEmployee.timeoff_quota}}"
                                                            style="width: {{selectedEmployee.timeoff_percent}}%">
                                                            <span class="sr-only">{{selectedEmployee.timeoff_percent}} %
                                                                Timeoff</span>
                                                        </div>
                                                    </div>
                                                    <b>Sick Leave Availability</b> <a class="float-right">used
                                                        {{ selectedEmployee.timeoff_used }} out of
                                                        {{selectedEmployee.timeoff_quota}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Email</b> <a
                                                        class="float-right">{{ selectedEmployee.gothaimail}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tel</b> <a class="float-right">{{selectedEmployee.mobile}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A330
                                                    <a class="float-right">
                                                        {{selectedEmployee.a330 == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A350
                                                    <a class="float-right">
                                                        {{selectedEmployee.a350 == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li class="list-group-item"><span class="fa-li"></span> A350 Cruise
                                                    <a class="float-right">
                                                        {{selectedEmployee.a350cruise == '1' ? 'Yes' :'No'}}</a></li>
                                                <li ng-if="selectedEmployee.sub_rank == 'FC'" class="list-group-item">
                                                    <span class="fa-li"></span>
                                                    RH Qualified
                                                    <a class="float-right">
                                                        {{selectedEmployee.rh_qualified == '1' ? 'Yes' :'No'}}</a>
                                                </li>
                                                <li ng-if="selectedEmployee.sub_rank == 'FP'" class="list-group-item">
                                                    <span class="fa-li"></span>
                                                    LH Qualified
                                                    <a class="float-right">
                                                        {{selectedEmployee.lh_qualified == '1' ? 'Yes' :'No'}}</a>
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
                                                        ng-model="selectedEmployee.date"
                                                        ng-class="selectedEmployee.date == '' || selectedEmployee.date == undefined ? 'required-element' : ''"
                                                        data-date-format="yyyy/mm/dd">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">ประเภท : <span
                                                            class="required">*</span></span>&nbsp;
                                                </div>
                                                <select class="form-control" ng-model="selectedEmployee.type"
                                                    ng-class="selectedEmployee.type == '' || selectedEmployee.type == undefined ? 'required-element' : ''">
                                                    <option value="" disabled>-- ประเภท --</option>
                                                    <option value="good">ประพฤติกระทำความดี</option>
                                                    <option value="bad">ประพฤติกระทำความผิด</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Flight : </span>&nbsp;
                                                    <input class="form-control" placeholder=""
                                                        ng-model="selectedEmployee.flight">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <span class="font-weight-bold">Note </span>&nbsp;
                                                </div>
                                                <textarea ng-model="selectedEmployee.note" style="resize:none" rows="4"
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
<script src="includes/plugins/daterangepicker/daterangepicker.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="scripts/employee_list.js?t=<?=time()?>"></script>