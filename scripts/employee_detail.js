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
    ],
}

$(document).ready(function(){
    tbBehavior = $("#tbBehavior").DataTable(options);
    tbTimeoff = $("#tbTimeoff").DataTable(optionsTF);
    $('.datepicker').datepicker({
        autoclose: true,
        language: 'TH',
    });
});

function onEdit(id) {
    angular.element(document.getElementById('dvBehaviorList')).scope().onEdit(id);
}
function onDelete(id) {
    angular.element(document.getElementById('dvBehaviorList')).scope().onDelete(id);
}

app.controller('empDetailCtrl', function ($scope, $http, $q ,$window) {
    $scope.file_upload = "";
    $scope.selectedRecord = {};
    $scope.item = {};
    $scope.update = {};
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
            $scope.item = data;
            // json_list = data;

            // tbBehavior.clear();
            // tbBehavior.rows.add(json_list);
            // tbBehavior.draw();
            
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

    
});