var json_list = [];
var tbTimeoff;
var options = {
    dom: 'Bfrtip',
    buttons: [
        'pdfHtml5'
    ],
    paging: false,
    bInfo: false,
    bFilter: true,
    lengthChange:false,
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
          title: "Name",
          width: "80px",
          data: "name_en"
        },
        {
          title: "Surname",
          width: "80px",
          data: "surname_en"
        },
        {
          title: "Mobile",
          width: "100px",
          data: "mobile"
        },
        {
          title: "Gothaimail",
          width: "100px",
          data: "gothaimail"
        },
        {
            title: "Sick Leave",
            width: "100px",
            data: "count_sick"
        },
    ],
}
var lineChartCanvas;
$(function() {
    $('.datepicker').datepicker({
        autoclose: true,
        language: 'TH',
    });

    tbTimeoff = $("#tbTimeoff").DataTable(options);

    document.getElementById("lineChart").onclick = function(e) 
    {
        var activeElement = lineChartCanvas.lastTooltipActive;
        console.log(activeElement);
    };
});

app.controller('myCtrl', function($scope, $http, $q) {
    $scope.file_upload = "";
    $scope.selectedYear = "";
    $scope.dashboard = {};
    angular.element(document).ready(function() {
        $scope.getDashboardSummary();
        setTimeout(() => {
          $scope.selectedYear = yyyy;
          $scope.$apply();
          console.log($scope.selectedYear);
        }, 100);
        
    });
    $scope.sumFC = 0;
    $scope.sumFP = 0;
    $scope.years = [2019, 2020, 2021, 2022, 2023];
    
    $scope.getDashboardSummary = function() {
        showLoading();
        $scope.getSummaryDashboard().then(function(data) {
         
          setTimeout(function() {
              $scope.dashboard = data;
              $scope.dashboard.all_emp = parseInt($scope.dashboard.all_cap) + parseInt($scope.dashboard.all_co);
              $scope.$apply();
              hideLoading();
          }, 100);

        });
        $scope.getSummaryYear().then(function(data) {
            console.log(data);
            $scope.sumFC =0;
            $scope.sumFP =0;
            setTimeout(function() {
                lineChartCanvas = $('#lineChart').get(0).getContext('2d')
                var summaryData = {};
                summaryData.labels = ['January', 'February', 'March', 'April', 'May',
                    'June', 'July', 'August', 'September', 'October', 'November',
                    'December'
                ];
                summaryData.datasets = [];
                data.forEach(e => {
                    summaryData.datasets.push({
                        label: e.rank,
                        data: [e.January, e.February, e.March, e.Apirl, e.May, e.June, e.July, e.August, e.September,
                            e.October, e.November, e.December
                        ],
                        borderColor: e.rank == 'FC' ? 'red' : 'green',
                        fill: false
                    })
                    $scope.sumFC = data.find(e=>e.rank == "FC").sumall;
                    $scope.sumFP = data.find(e=>e.rank == "FP").sumall;
                });
               
                var lineChart = new Chart(lineChartCanvas, {
                    type: 'line',
                    data: summaryData,
                    options: {
                      legend:{
                        display: false
                      }
                    }
                })
                console.log(summaryData);
                $scope.$apply();
                hideLoading();
            }, 100);

        });
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

    $scope.getSummaryDashboard = function() {
      var dfrd = $q.defer();
      $http({
          method: 'GET',
          url: 'function/select.php',
          headers: {
            'Cache-Control': 'no-cache',
            'Pragma':'no-cache'
          },
          params: {
              action: "get_dashboard_summary",
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
      }, function(error) {
          showError(error.message);
          hideLoading();
          return
      });
      return dfrd.promise;
    }

    $scope.getSummaryMonth = function() {
      var dfrd = $q.defer();
      $http({
          method: 'GET',
          url: 'function/select.php',
          headers: {
            'Cache-Control': 'no-cache',
            'Pragma':'no-cache'
          },
          params: {
              action: "get_summary_sick_by_month",
              params: $scope.selectedYear
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
      }, function(error) {
          showError(error.message);
          hideLoading();
          return
      });
      return dfrd.promise;
    }

    $scope.getSummaryYear = function() {
        var dfrd = $q.defer();
        $http({
            method: 'GET',
            url: 'function/select.php',
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma':'no-cache'
            },
            params: {
                action: "get_summary_sick_by_year",
                params: $scope.selectedYear
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
        }, function(error) {
            showError(error.message);
            hideLoading();
            return
        });
        return dfrd.promise;
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
          action: "get_timeoff_sum_by_emp"
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

});