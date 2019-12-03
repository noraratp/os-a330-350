var json_list = [];
var tbBehavior;
var options = {
    paging: true,
    bInfo: false,
    bFilter: true,
    data: json_list,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [
        {
            title: "Employee",
            width: "150px",
            data: "employee_display"
        },
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
            width: "100px",
            render: function(data, type, row, meta) {
                if (type === 'display') {
                    if(row.type == 'good') {
                        data = "<span class='text-success'>"+row.type_display+"</span>";
                    }
                    else {
                        data = "<span class='text-danger'>"+row.type_display+"</span>";
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

$(document).ready(function(){
    tbBehavior = $("#tbBehavior").DataTable(options);

    $('.datepicker').datepicker({
        autoclose: true,
        language: 'TH',
    });
});

function onEdit(id) {
    angular.element(document.getElementById('dvBehaviorList')).scope().onEdit(id);
}
function onDelete(id) {
    angular.element(document.getElementById('dvBehaviorList')).scope().onConfirmDelete(id);
}

app.controller('behaviorListCtrl', function ($scope, $http, $q) {
    $scope.selectedRecord = {};
    $scope.deletedItem = 0;
    angular.element(document).ready(function () {
        $scope.searchBehavior();
    });

    $scope.searchBehavior = function () {
        $scope.getBehavior().then(function (data) {
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
    
    $scope.getBehavior = function () {
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
        action: "get_behavior_list"
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

            $scope.$apply();
            $('#modalBehavior').modal("show");
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
        $('#modalConfirmBehavior').modal("show");
    }

    $scope.onSave = function() {
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
                    $('#modalInput').modal("hide");
                    showSuccess("บันทึกข้อมูลสำเร็จ", false);
                    $scope.searchBehavior();
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

    $scope.onConfirmDelete = function(id) {
        $scope.deletedItem = id;
        $('#modalConfirmDelete').modal("show");
    }
    $scope.onDelete = function(id) {
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
                    $('#modalConfirmDelete').modal("hide");
                    showSuccess("ลบข้อมูลสำเร็จ", false);
                    $scope.deletedItem = 0;
                    $scope.searchBehavior();
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