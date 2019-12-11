<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<link rel="stylesheet" href="includes/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link href="includes/plugins/datepicker/datepicker.css" rel="stylesheet">
<link rel="stylesheet" href="includes/plugins/daterangepicker/daterangepicker.css">

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
                                    {{item.f_surname_en}} <a href="#" ng-click="onEditProfile(item)"><i
                                            class="fas fa-edit"></i></a></h3>

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
                                        <span class=""><i class="fas fa-lg fa-envelope"></i></span> Email
                                        <a class="float-right">{{item.gothaimail}}</a>

                                    </li>
                                    <li class="list-group-item">
                                        <span class=""><i class="fas fa-lg fa-phone"></i></span> Phone
                                        <a class="float-right"> {{item.mobile}} </a>

                                    </li>
                                    <li class="list-group-item"><span class="fa-li"></span> A330
                                        <a class="float-right">
                                            {{item.a330 == '1' ? 'Yes' :'No'}}</a>
                                    </li>
                                    <li class="list-group-item"><span class="fa-li"></span> A350
                                        <a class="float-right">
                                            {{item.a350 == '1' ? 'Yes' :'No'}}</a>
                                    </li>
                                    <li class="list-group-item"><span class="fa-li"></span> A350 Cruise
                                        <a class="float-right">
                                            {{item.a350cruise == '1' ? 'Yes' :'No'}}</a></li>
                                    <li ng-if="item.sub_rank == 'FC'" class="list-group-item">
                                        <span class="fa-li"></span>
                                        RH Qualified
                                        <a class="float-right">
                                            {{item.rh_qualified == '1' ? 'Yes' :'No'}}</a>
                                    </li>
                                    <li ng-if="item.sub_rank == 'FP'" class="list-group-item">
                                        <span class="fa-li"></span>
                                        LH Qualified
                                        <a class="float-right">
                                            {{item.lh_qualified == '1' ? 'Yes' :'No'}}</a>
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
        
        <div class="modal fade bd-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog"
            aria-labelledby="modalDetail" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="exampleModalLabel">อัพเดทข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvEmployeeUpdate">
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="name_en" class="col-form-label">Name <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="text" class="form-control" id="name_en" ng-model="update.name_en"
                                ng-pattern="/^[a-zA-Z]*$/" ng-trim="false"
                                ng-class="update.name_en == '' || update.name_en == undefined ? 'required-element' : ''">
                            &nbsp;
                            <label style="width:100px" for="surname_en" class="col-form-label">Surname <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="text" class="form-control" id="surname_en" ng-model="update.surname_en"
                                ng-pattern="/^[a-zA-Z]*$/" ng-trim="false"
                                ng-class="update.surname_en == '' || update.surname_en == undefined ? 'required-element' : ''">
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="name_th" class="col-form-label">ชื่อ <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="text" class="form-control" id="name_th" ng-model="update.name_th"
                                ng-class="update.name_th == '' || update.name_th == undefined ? 'required-element' : ''">
                            &nbsp;
                            <label style="width:100px" for="surname_th" class="col-form-label">นามสกุล <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="text" class="form-control" id="surname_th" ng-model="update.surname_th"
                                ng-class="update.surname_th == '' || update.surname_th == undefined ? 'required-element' : ''">
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="nickname" class="col-form-label">Nickname </label> :
                            &nbsp;
                            <input type="text" class="form-control" id="nickname" ng-model="update.nickname">
                            &nbsp;
                            <label style="width:100px" for="pers" class="col-form-label">Pers </label> :
                            &nbsp;
                            <input type="text" class="form-control" id="pers" ng-model="update.pers" readonly>
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="rankg" class="col-form-label">Rank <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <select ng-model="update.rank" class="form-control">
                                <option ng-repeat="item in rankList" value="{{item.value}}">{{item.text}}</option>
                            </select>
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="mobile" class="col-form-label">Mobile <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="tel" class="form-control" id="mobile" ng-model="update.mobile"
                                ng-class="update.mobile == '' || update.mobile == undefined ? 'required-element' : ''">
                            &nbsp;
                            <label style="width:100px" for="gothaimail" class="col-form-label">Gothaimail <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="email" class="form-control" id="email" ng-model="update.gothaimail"
                                ng-class="update.gothaimail == '' || update.gothaimail == undefined ? 'required-element' : ''">
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="quota" class="col-form-label">Leave Quota <span
                                    class="required">*</span></label> :
                            &nbsp;
                            <input type="text" numbers-only class="form-control" id="quota"
                                ng-model="update.timeoff_quota"
                                ng-class="update.timeoff_quota == '' || update.timeoff_quota == undefined ? 'required-element' : ''">
                            &nbsp;
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="a330" class="col-form-label">A330 </label> :
                            &nbsp;
                            <input class="form-check-input" name="a330" ng-model="update.a330" type="checkbox">
                            &nbsp;
                            <label style="width:100px" for="a350" class="col-form-label">A350 </label> :
                            &nbsp;
                            <input class="form-check-input" name="a330" ng-model="update.a350" type="checkbox">
                            &nbsp;
                            <label style="width:150px" for="a350cruise" class="col-form-label">A350 Cruise </label> :
                            &nbsp;
                            <input class="form-check-input" name="a350cruise" ng-model="update.a350cruise"
                                type="checkbox">
                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label ng-if="update.sub_rank == 'FC'" style="width:100px" for="rh_qualified"
                                class="col-form-label">RH Qualified :</label>
                            &nbsp;
                            <input ng-if="update.sub_rank == 'FC'" class="form-check-input" name="rh_qualified"
                                ng-model="update.rh_qualified" type="checkbox">

                            <label ng-if="update.sub_rank == 'FP'" style="width:100px" for="lh_qualified"
                                class="col-form-label">LH Qualified :</label>
                            &nbsp;
                            <input ng-if="update.sub_rank == 'FP'" class="form-check-input" name="lh_qualified"
                                ng-model="update.lh_qualified" type="checkbox">

                        </div>
                        <div class="form-inline" style="margin-bottom:10px">
                            <label style="width:100px" for="employee" class="col-form-label">รูปภาพ </label> :
                            &nbsp;
                            <input type="file" file-input="file_upload" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" ng-click="onSubmitUpdate()">ยืนยัน</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
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
                    <div class="modal-body" id="dvBodyTF">
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
        <div class="modal fade" id="modalConfirmDeleteBH" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteBH"
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
<script src="includes/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="includes/plugins/daterangepicker/daterangepicker.js"></script>
<script src="scripts/employee_detail.js">
</script>