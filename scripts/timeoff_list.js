var json_list = [];
var tbTimeoff;
var options = {
    paging: true,
    bInfo: false,
    bFilter: true,
    data: json_list,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [{
        title: "#",
        data: "id",
        width: "50px",
        render: function(data, type, row, meta) {
            if (type === 'display') {
                data = '<a onclick="onEdit(' + row.id + ')" href="#" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>&nbsp' +
                    '<a onclick="onDelete(' + row.id + ')" href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
            }

            return data;
        }
    },
        {
            title: "Employee",
            width: "120px",
            data: "employee_display"
        },
        {
            title: "Flight",
            width: "80px",
            data: "flight"
        },
        {
            title: "จำนวนวันลา",
            width: "100px",
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
            title: "หมายเหตุ",
            data: "note",
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
            title: "สร้างโดย",
            data: "created_by",
            width: "100px"
        },
        {
            title: "วันที่สร้าง",
            data: "created_date",
            width: "100px"
        },
        {
            title: "แก้ไขโดย",
            data: "updated_by",
            width: "100px"
        },
        {
            title: "วันที่แก้ไข",
            data: "updated_date",
            width: "100px"
        }
    ],
}

$(document).ready(function(){
    tbTimeoff = $("#tbTimeoff").DataTable(options);

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
    angular.element(document.getElementById('dvTimeoffList')).scope().setSickLeaveDays(val, start, end);
}
function onEdit(id) {
    angular.element(document.getElementById('dvTimeoffList')).scope().onEdit(id);
}
function onDelete(id) {
    angular.element(document.getElementById('dvTimeoffList')).scope().onDelete(id);
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

app.controller('timeoffListCtrl', function ($scope, $http, $q) {
    $scope.selectedRecord = {};
    angular.element(document).ready(function () {
        $scope.searchTimeoff();
    });

    $scope.searchTimeoff = function () {
        $scope.getTimeoff().then(function (data) {
          setTimeout(function(){
            json_list = data;

            tbTimeoff.clear();
            tbTimeoff.rows.add(json_list);
            tbTimeoff.draw();
            
            $scope.$apply();
            hideLoading();
          },100);
        });
      }
    
    $scope.getTimeoff = function () {
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
        action: "get_timeoff_list"
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

    $scope.setSickLeaveDays = function(val, start, end){
        setTimeout(() => {
          $scope.selectedRecord.days = val;
          $scope.selectedRecord.start_date = start;
          $scope.selectedRecord.end_date = end;
          $scope.$apply();
        }, 100);
        
      }

    $scope.onEdit = function(id) {
        showLoading();
        setTimeout(() => {
            $scope.selectedRecord = {};
            $scope.selectedRecord = json_list.find(e=>e.id == id);
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
        if ($(".form-control").hasClass("required-element")) {
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
                                showSuccess("บันทึกข้อมูลสำเร็จ", false);
                                $scope.searchTimeoff();
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

    $scope.onDelete = function(id) {

    }
    
});