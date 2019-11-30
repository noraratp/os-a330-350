$(function () {
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
  angular.element(document.getElementById('dvSickleave')).scope().setSickLeaveDays(val, start, end);
}

app.controller('empListCtrl', function ($scope, $http, $q ,$window) {
  $scope.employeeList = [];
  $scope.filterTezt = "";
  $scope.selectedEmployee = {};

  angular.element(document).ready(function () {
    $scope.searchEmployee();
  });

  $scope.searchEmployee = function () {
    $scope.selectedEmployee = {};
    $scope.getEmployee().then(function (data) {
     
      setTimeout(function(){
        $scope.employeeList = data;
        console.log($scope.employeeList[0])
        $scope.$apply();
        hideLoading();
      },100);
    });
  }

  $scope.getEmployee = function () {
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
        action: "get_employee_list"
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
      console.log(error);
      showError(error.message);
      hideLoading();
      return
    });
    return dfrd.promise;
  }

  $scope.onSickLeave = function(id) {
    $scope.selectedEmployee = {};
    $scope.selectedEmployee = $scope.employeeList.find(e=>e.id == id);
    $('#modalInput').modal("show");
  }
  $scope.setSickLeaveDays = function(val, start, end){
    setTimeout(() => {
      $scope.selectedEmployee.leave_days = val;
      $scope.selectedEmployee.start_date = start;
      $scope.selectedEmployee.end_date = end;
      $scope.$apply();
    }, 100);
    
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
                
                $scope.selectedEmployee.medical_cert = response.data
                console.log($scope.selectedEmployee)
                $http({
                    method: "post",
                    url: "function/insert.php",
                    data: {
                        post_data: $scope.selectedEmployee,
                        action: "insert_leave"
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(response) {
                        if (response.status == 200) {
                            hideLoading();
                            $('#modalInput').modal("hide");
                            showSuccess("บันทึกข้อมูลสำเร็จ", false);
                            $scope.searchEmployee();
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

});