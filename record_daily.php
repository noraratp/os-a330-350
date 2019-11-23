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
    <div ng-app="myApp" ng-controller="recordDairyCtrl" class="card" id="dvForm">
        <div class="card-header">
            <h3 class="card-title">
                <?echo $PAGE_TITLE ?>
            </h3>
        </div>
        <div class="card-body">
            <div class="form-inline">
                <div class="col" style="margin-bottom:10px;">
                    <button ng-click="saveData()" class="btn btn-success">บันทึก</button>
                    <button class="btn btn-danger">ยกเลิก</button>
                </div>
            </div>

            <div class="col">
                <div class="card-header bg-primary">
                    <h3 class="card-title">ข้อมูลทั่วไป</h3>
                </div>
                <div class="form-group">
                    <div class="form-inline">
                        <span class="font-weight-bold">วันที่ให้บริการ : <span class="required">*</span></span>&nbsp;
                        <input class="form-control datepicker" placeholder="ปี/เดือน/วัน" ng-model="service_date"
                            ng-class="service_date == '' || service_date == undefined ? 'required-element' : ''"
                            data-date-format="yyyy/mm/dd">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline">
                        <label for="customer" class="col-form-label">ลูกค้า <span class="required">*</span></label> :
                        &nbsp;
                        <input type="text" class="form-control" id="customer" ng-model="create.customer.display"
                            readonly ng-click="searchCustomer()"
                            ng-class="create.customer.display == '' || create.customer.display == undefined ? 'required-element' : ''">
                        &nbsp;
                        <button class="btn btn-success" ng-click="searchCustomer()"><i
                                class="fas fa-search"></i></button>
                        &nbsp;
                        <button class="btn btn-primary"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-header bg-primary">
                    <h3 class="card-title">รายละเอียดลูกค้า</h3>
                </div>
                <div class="form-group">
                    <table class="table" style="width:80%">
                        <tr>
                            <td style="width=100px;">
                                ชื่อ
                            </td>
                            <td class="text-primary">
                                {{ create.customer.firstname || "-" }}
                            </td>
                            <td>
                                นามสกุล
                            </td>
                            <td class="text-primary">
                                {{ create.customer.lastname || "-" }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                เบอร์โทรศัพท์
                            </td>
                            <td class="text-primary">
                                {{ create.customer.tel || "-" }}
                            <td>
                                ชื่อเล่น
                            </td>
                            <td class="text-primary">
                                {{ create.customer.nickname || "-" }}
                            </td>
                        </tr>
                        <tr>
                            </td>
                            <td>
                                ชื่อผู้ติดต่อ
                            </td>
                            <td class="text-primary">
                                {{ create.customer.contact_name || "-" }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-header bg-primary">
                    <h3 class="card-title">รายละเอียดการให้บริการ</h3>
                </div>
                <div class="form-group">
                    <button ng-click="addService()" class="btn btn-success" style="margin-top:10px"><i
                            class="fas fa-plus"></i>
                        เพิ่มรายการ</button>
                    <table class="table" id="tbService" style="width:80%">

                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-md" id="modalCreate" tabindex="-1" role="dialog"
            aria-labelledby="modalCreate" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดงานบริการ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvBody">
                        <div class="form-group">
                            <label for="media_name" class="col-form-label">รถลูกค้า <span class="required">*</span>
                            </label>
                            <select ng-model="service.vehicle_id" class="form-control select2" style="width: 100%;"
                                ng-class="service.vehicle_id == '' || service.vehicle_id == undefined ? 'required-element' : ''">
                                <option disabled selected value="">-- เลือกรถ --</option>
                                <option ng-repeat="item in vehicleList" value="{{item.id}}">{{item.plate_no }} - ยี่ห้อ
                                    : {{ item.brand }} | {{item.description}}
                                </option>
                            </select>


                        </div>
                        <div class="form-group">
                            <label for="media_display" class="col-form-label">ประเภทการให้บริการ: <span
                                    class="required">*</span></label>
                            <input type="text" class="form-control" id="media_display" ng-model="service.service_type"
                                ng-class="service.service_type == '' || service.service_type == undefined ? 'required-element' : ''">
                        </div>
                        <div class="form-group">
                            <label for="media_url" class="col-form-label">รายละเอียดการให้บริการ <span
                                    class="required">*</span></label>
                            <textarea id="txtAreaDesc" class="form-control" rows="5" ng-model="service.description"
                                ng-class="service.description == '' || service.description == undefined ? 'required-element' : ''"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="user_access" class="col-form-label">จำนวนเงิน</label>
                            <input type="text" id="user_access" class="form-control" numbers-only
                                ng-model="service.price">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" ng-click="onSubmitService()">ยืนยัน</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modalSearchCustomer" tabindex="-1" role="dialog"
            aria-labelledby="modalSearchCustomer" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">ค้นหาลูกค้า</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="dvBody">
                        <table class="table table-hover" width="100%" id="tbSearchCustomer"></table>
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
<script src="includes/plugins/select2/js/select2.full.min.js"></script>
<script src="scripts/record_daily.js"></script>