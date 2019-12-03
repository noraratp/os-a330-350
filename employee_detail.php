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
    </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>
<script src="includes/plugins/datatables/jquery.dataTables.js"></script>
<script src="includes/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="includes/plugins/datepicker/moment.min.js"></script>
<script src="includes/plugins/datepicker/datepicker.js"></script>
<script src="scripts/employee_detail.js">
</script>