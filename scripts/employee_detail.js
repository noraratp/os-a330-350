var json_list = [];
var tbBehavior;
var options = {
    paging: true,
    pageLength:5,
    lengthChange:false,
    bInfo: false,
    bFilter: false,
    data: json_list,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [
        {
            title: "Flight",
            width: "80px",
            data: "flight"
        },
        {
            title: "วันที่บันทึก",
            data: "date",
            width: "100px"
        },
        {
            title: "ความประพฤติ",
            data: "type_display",
            width: "100px"
        },
        {
            title: "หมายเหตุ",
            data: "note",
        },
        {
            title: "#",
            data: "id",
            width: "100px",
            render: function(data, type, row, meta) {
                if (type === 'display') {
                    data = '<a onclick="onEdit(' + row.id + ')" href="#" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>&nbsp' +
                        '<a onclick="onDelete(' + row.id + ')" href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                }
    
                return data;
            }
        },
    ],
}

var json_listTF = [];
var tbTimeoff;
var optionsTF = {
    paging: true,
    lengthChange:false,
    pageLength:5,
    bInfo: false,
    bFilter: false,
    data: json_listTF,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [
        {
            title: "Flight",
            width: "80px",
            data: "flight"
        },
        {
            title: "จำนวนวันลา",
            width: "50px",
            data: "days"
        },
        {
            title: "วันที่เริ่มลา",
            data: "start_date",
            width: "100px"
        },
        {
            title: "ถึงวันที่",
            data: "end_date",
            width: "100px"
        },
        
        {
            title: "ใบรับรองแพทย์",
            data: "medical_cert",
            render: function(data, type, row, meta) {
                if (type === 'display') {
                    if(data === "") { 
                        data = '-';
                    }
                    else {
                        data = '<a href="' + row.medical_cert + '" target="_blank">มี</a>';
                    }
                }

                return data;
            }
        },
        {
            title: "หมายเหตุ",
            data: "note",
        },
        {
            title: "#",
            data: "id",
            width: "100px",
            render: function(data, type, row, meta) {
                if (type === 'display') {
                    data = '<a onclick="onEditTimeOff(' + row.id + ')" href="#" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>&nbsp' +
                        '<a onclick="onDeleteTimeOff(' + row.id + ')" href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                }
    
                return data;
            }
        },
    ],
}

$(document).ready(function(){
    tbBehavior = $("#tbBehavior").DataTable(options);
    tbTimeoff = $("#tbTimeoff").DataTable(optionsTF);
    $('.datepicker').datepicker({
        autoclose: true,
        language: 'TH',
    });

    $('#reservation').daterangepicker({
        locale: {
                 format: 'YYYY/DD/MM'
                },        
        }).on('apply.daterangepicker', function(ev, picker) {debugger
                    var start = moment(picker.startDate.format('YYYY-MM-DD'));
                    var end   = moment(picker.endDate.format('YYYY-MM-DD'));
                    var diff = (start.diff(end, 'days') * -1) + 1; // returns correct number
                    start = picker.startDate.format('YYYY/MM/DD');
                    end = picker.endDate.format('YYYY/MM/DD');
                    setSickLeaveDays(diff, start, end);
      });

});

function setSickLeaveDays(val, start, end) {
    angular.element(document.getElementById('dvEmployeeDetail')).scope().setSickLeaveDays(val, start, end);
}
function onEditTimeOff(id) {
    angular.element(document.getElementById('dvEmployeeDetail')).scope().onEditTimeOff(id);
}
function onDeleteTimeOff(id) {
    angular.element(document.getElementById('dvEmployeeDetail')).scope().onConfirmDelete(id);
}
function setIntialDate(start, end){
    console.log(start,end)
    $('#reservation').daterangepicker({
        locale: {
                 format: 'YYYY/DD/MM'
                },
        startDate:  moment(start.replace("-","/")),
        endDate:  moment(end.replace("-","/")),
        }).on('apply.daterangepicker', function(ev, picker) {debugger
                    var start = moment(picker.startDate.format('YYYY-MM-DD'));
                    var end   = moment(picker.endDate.format('YYYY-MM-DD'));
                    var diff = (start.diff(end, 'days') * -1) + 1; // returns correct number
                    start = picker.startDate.format('YYYY/MM/DD');
                    end = picker.endDate.format('YYYY/MM/DD');
                    setSickLeaveDays(diff, start, end);
      });
}
function onEdit(id) {
    angular.element(document.getElementById('dvEmployeeDetail')).scope().onEditBehavior(id);
}
function onDelete(id) {
    angular.element(document.getElementById('dvEmployeeDetail')).scope().onConfirmDeleteBehavior(id);
}

app.controller('empDetailCtrl', function ($scope, $http, $q ,$window) {
    $scope.file_upload = "";
    $scope.selectedRecord = {};
    $scope.item = {};
    $scope.update = {};
    $scope.deletedItem = {};
    $scope.rankList = [{
        text: "FC",
        value: "FC"
    },
    {
        text: "FCH",
        value: "FCH"
    },
    {
        text: "FCI",
        value: "FCI"
    },
    {
        text: "FCIV",
        value: "FCIV"
    },
    {
        text: "FCR",
        value: "FCR"
    },
    {
        text: "FCRH",
        value: "FCRH"
    },
    {
        text: "FCRV",
        value: "FCRV"
    },
    {
        text: "FCS",
        value: "FCS"
    },
    {
        text: "FCT",
        value: "FCT"
    },
    {
        text: "FCV",
        value: "FCV"
    },
    {
        text: "FCVI",
        value: "FCVI"
    },
    {
        text: "FP",
        value: "FP"
    },
    {
        text: "FPI",
        value: "FPI"
    },
    {
        text: "FPIR",
        value: "FPIR"
    },
    {
        text: "FPM",
        value: "FPM"
    },
    {
        text: "FPR",
        value: "FPR"
    },
    {
        text: "FPT",
        value: "FPT"
    }
]
    angular.element(document).ready(function () {
        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');
        if(id == undefined) {
            $window.location = "index.php";
        }
        $scope.searchEmployee(id);
        $scope.searchTimeoff(id);
        $scope.searchBehavior(id);
    });

    $scope.searchEmployee = function (id) {
        $scope.getEmployee(id).then(function (data) {
          setTimeout(function(){
            console.log(data);
            data.a330 = data.a330 == "1" ? true :false;
            data.a350 = data.a350 == "1" ? true :false;
            data.a350cruise = data.a350cruise== "1" ? true :false;
            data.rh_qualified = data.rh_qualified == "1" ? true :false;
            data.lh_qualified = data.lh_qualified == "1" ? true :false;
            $scope.item = data;
        
            $scope.$apply();
            hideLoading();
          },100);
        });
      }
    
    $scope.getEmployee = function (id) {
    showLoading();
    var dfrd = $q.defer();
    $http({
        method: 'GET',
        url: 'function/select.php',
        headers: {
        'Cache-Control': 'no-cache',
        'Pragma':'no-cache'
        },
        params: {
        action: "get_employee_by_id",
        id:id
        },
    }).then(function successCallback(response) {
        if (response.status == 200) {
        $scope.data = response.data.message;
        dfrd.resolve($scope.data);
        } else {
        showError(response.data.message);
        hideLoading();
        return
        }
    }, function (error) {
        showError(error.message);
        hideLoading();
        return
    });
    return dfrd.promise;
    }

    $scope.searchTimeoff = function (id) {
        $scope.getTimeoff(id).then(function (data) {
          setTimeout(function(){
            json_listTF = data;

            tbTimeoff.clear();
            tbTimeoff.rows.add(json_listTF);
            tbTimeoff.draw();
            
            $scope.$apply();
            hideLoading();
          },100);
        });
      }
    
    $scope.getTimeoff = function (id) {
    showLoading();
    var dfrd = $q.defer();
    $http({
        method: 'GET',
        url: 'function/select.php',
        headers: {
        'Cache-Control': 'no-cache',
        'Pragma':'no-cache'
        },
        params: {
        action: "get_timeoff_list",
        id:id
        },
    }).then(function successCallback(response) {
        if (response.status == 200) {
        $scope.data = response.data.message;
        dfrd.resolve($scope.data);
        } else {
        showError(response.data.message);
        hideLoading();
        return
        }
    }, function (error) {
        showError(error.message);
        hideLoading();
        return
    });
    return dfrd.promise;
    }

    $scope.searchBehavior = function (id) {
        $scope.getBehavior(id).then(function (data) {
          setTimeout(function(){
            json_list = data;

            tbBehavior.clear();
            tbBehavior.rows.add(json_list);
            tbBehavior.draw();
            
            $scope.$apply();
            hideLoading();
          },100);
        });
      }
    
    $scope.getBehavior = function (id) {
    showLoading();
    var dfrd = $q.defer();
    $http({
        method: 'GET',
        url: 'function/select.php',
        headers: {
        'Cache-Control': 'no-cache',
        'Pragma':'no-cache'
        },
        params: {
        action: "get_behavior_list",
        id:id
        },
    }).then(function successCallback(response) {
        if (response.status == 200) {
        $scope.data = response.data.message;
        dfrd.resolve($scope.data);
        } else {
        showError(response.data.message);
        hideLoading();
        return
        }
    }, function (error) {
        showError(error.message);
        hideLoading();
        return
    });
    return dfrd.promise;
    }

    $scope.onEditProfile = function(data) {
        showLoading();
        setTimeout(function(){
            angular.copy(data, $scope.update)
            $scope.$apply();
            $('#modalDetail').modal('show');
            hideLoading();
        },100);
        
    }

    $scope.onSubmitUpdate = function() {
        if ($("#dvEmployeeUpdate .form-control").hasClass("required-element")) {
            hideLoading();
            showError("กรุณาตรวจสอบข้อมูลให้ครบถ้วน");
            return;
        }
        $scope.update.a330 = $scope.update.a330 == true ? "1" :"0";
        $scope.update.a350 = $scope.update.a350 == true ? "1" :"0";
        $scope.update.a350cruise = $scope.update.a350cruise == true ? "1" :"0";
        $scope.update.rh_qualified = $scope.update.rh_qualified == true ? "1" :"0";
        $scope.update.lh_qualified = $scope.update.lh_qualified == true ? "1" :"0";

        var form_data = new FormData();
        angular.forEach($scope.file_upload, function(file) {
            form_data.append('file', file);
        });
        $http.post('function/libs/upload_file.php', form_data, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined,
                'Process-Data': false
            },
        }).then(function(response) {
                $scope.update.picture = response.data == "" ? $scope.update.picture : response.data;
                console.log($scope.update);
                if($scope.update.id != undefined) {
                    $http({
                    method: "post",
                    url: "function/insert.php",
                    data: {
                        post_data: $scope.update,
                        action: "update_employee"
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                    }).then(function(response) {
                            if (response.status == 200) {
                                hideLoading();
                                showSuccess("บันทึกข้อมูลสำเร็จ", true);
                            } else {
                                hideLoading();
                                showError(response.data.message);
                            }
                        },
                    function(response) { // optional
                        // failed
                        hideLoading();
                        showError(response.data.message);
                    });

                }
                // else {
                //     $http({
                //     method: "post",
                //     url: "function/insert.php",
                //     data: {
                //         post_data: $scope.create,
                //         action: "insert_customer"
                //     },
                //     headers: {
                //         'Content-Type': 'application/x-www-form-urlencoded'
                //     }
                //     }).then(function(response) {
                //             if (response.status == 200) {
                //                 hideLoading();
                //                 showSuccess("บันทึกข้อมูลสำเร็จ", true);
                //             } else {
                //                 hideLoading();
                //                 showError(response.data.message);
                //             }
                //         },
                //     function(response) { // optional
                //         // failed
                //         hideLoading();
                //         showError(response.data.message);
                //     });
                // }
            },
            function(response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
    }

    // EDIT TIME OFF

    $scope.setSickLeaveDays = function(val, start, end){
        setTimeout(() => {
          $scope.selectedRecord.days = val;
          $scope.selectedRecord.start_date = start;
          $scope.selectedRecord.end_date = end;
          $scope.$apply();
        }, 100);
        
    }

    $scope.onEditTimeOff = function(id) {
        showLoading();
        setTimeout(() => {
            $scope.selectedRecord = {};
            $scope.selectedRecord = json_listTF.find(e=>e.id == id);

            $scope.selectedRecord.old_days = $scope.selectedRecord.days;
            $scope.selectedRecord.old_medical_cert = $scope.selectedRecord.medical_cert;
            setIntialDate($scope.selectedRecord.start_date,$scope.selectedRecord.end_date);
            $scope.$apply();
            $('#modalInput').modal("show");
            hideLoading();
            console.log($scope.selectedRecord);
        }, 500);
    }
    
    $scope.onConfirmSave = function(){
        if ($("#dvBodyTF .form-control").hasClass("required-element")) {
            hideLoading();
            showError("กรุณาตรวจสอบข้อมูลให้ครบถ้วน");
            return;
        }
        $('#modalConfirm').modal("show");
    }

    $scope.onSave = function() {
        $('#modalConfirm').modal("hide");
        showLoading();
        var form_data = new FormData();
            angular.forEach($scope.file_upload, function(file) {
                form_data.append('file', file);
            });
            $http.post('function/libs/upload_file.php', form_data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined,
                    'Process-Data': false
                },
            }).then(function(response) {
                    
                    $scope.selectedRecord.medical_cert = response.data
                    console.log($scope.selectedRecord)
                    $http({
                        method: "post",
                        url: "function/insert.php",
                        data: {
                            post_data: $scope.selectedRecord,
                            action: "update_leave"
                        },
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).then(function(response) {
                            if (response.status == 200) {
                                hideLoading();
                                $('#modalInput').modal("hide");
                                showSuccess("บันทึกข้อมูลสำเร็จ", true);
                            } else {
                                hideLoading();
                                showError(response.data.message);
                            }
                        },
                        function(response) { // optional
                            // failed
                            hideLoading();
                            showError(response.data.message);
                        });
                },
                function(response) { // optional
                    // failed
                    hideLoading();
                    showError(response.data.message);
                });
    }

    $scope.onConfirmDelete = function(id) {
        $scope.deletedItem = json_listTF.find(e=>e.id == id);
        $('#modalConfirmDelete').modal("show");
    }
    
    $scope.onDelete = function(id) {
        if( $scope.deletedItem.id == undefined) {
            showError("ไม่พบรายการที่เลือก");
            return;
        }
        console.log($scope.deletedItem);
        $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: $scope.deletedItem,
                action: "delete_leave"
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
                if (response.status == 200) {
                    hideLoading();
                    $('#modalConfirmDelete').modal("hide");
                    showSuccess("ลบข้อมูลสำเร็จ", true);
                } else {
                    hideLoading();
                    showError(response.data.message);
                }
            },
            function(response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
    }

    // EDIT BEHAVIOR

    $scope.onEditBehavior = function(id) {
        showLoading();
        setTimeout(() => {
            $scope.selectedRecord = {};
            $scope.selectedRecord = json_list.find(e=>e.id == id);

            $scope.$apply();
            $('#modalBehavior').modal("show");
            hideLoading();
            console.log($scope.selectedRecord);
        }, 500);
    }
    
    $scope.onConfirmSaveBehavior = function(){
        if ($("#dvBodyBehavior .form-control").hasClass("required-element")) {
            hideLoading();
            showError("กรุณาตรวจสอบข้อมูลให้ครบถ้วน");
            return;
        }
        $('#modalConfirmBehavior').modal("show");
    }

    $scope.onSaveBehavior = function() {
        $('#modalConfirmBehavior').modal("hide");
        showLoading();

        $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: $scope.selectedRecord,
                action: "update_behavior"
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
                if (response.status == 200) {
                    hideLoading();
                    $('#modalBehavior').modal("hide");
                    showSuccess("บันทึกข้อมูลสำเร็จ", true);
                } else {
                    hideLoading();
                    showError(response.data.message);
                }
            },
            function(response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
    }

    $scope.onConfirmDeleteBehavior = function(id) {
        $scope.deletedItem = id;
        $('#modalConfirmDeleteBH').modal("show");
    }
    $scope.onDeleteBehavior = function(id) {
        if( $scope.deletedItem == 0) {
            showError("ไม่พบรายการที่เลือก");
            return;
        }
        console.log($scope.deletedItem);
        $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: $scope.deletedItem,
                action: "delete_behavior"
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
                if (response.status == 200) {
                    hideLoading();
                    $('#modalConfirmDeleteBH').modal("hide");
                    showSuccess("ลบข้อมูลสำเร็จ", true);
                    $scope.deletedItem = 0;
                } else {
                    hideLoading();
                    showError(response.data.message);
                }
            },
            function(response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
    }

    
});