var tbServiceList;
var dataService = [];
var optionServiceTable = {
  paging: true,
  bInfo: false,
  bFilter: true,
  lengthChange: false,
  data: dataService,
  scrollY: "800px",
  scrollCollapse: true,
  autoWidth: true,
  pageLength: 5,
  columns: [
    {
      title: "ชื่อลูกค้า",
      data: "customer_display",
      width: "150px"
    },
    {
      title: "ทะเบียนรถ",
      data: "plate_no",
      width: "100px"
    },
    {
      title: "ยี่ห้อรถ",
      data: "brand",
      width: "50px"
    },
    {
      title: "สีรถ",
      data: "color",
      width: "50px",
    },
    {
      title: "ประเภทบริการ",
      data: "service_type",
      width: "150px"
    },
    {
      title: "รายละเอียด",
      data: "description"
    },
    {
      title: "ราคา",
      data: "item_price",
      render: $.fn.dataTable.render.number(',', '.', 0),
      width: "50px"
    },
    {
      title: "#",
      data: "action",
      width: "50px",
      defaultContent: "<button class='btn btn-warning'><i class='fas fa-search'></i></button>"

    }
  ],
}

$(function () {
  $('.datepicker').datepicker({
    autoclose: true,
    language: 'TH',
  });

  tbServiceList = $("#tbServiceList").DataTable(optionServiceTable);
  $('#tbServiceList tbody').on('click', 'button', function () {
    var data = tbServiceList.row($(this).parents('tr')).data();
    var index = dataService.indexOf(data);
    if (index !== -1) dataService.splice(index, 1);

    tbServiceList.clear();
    tbServiceList.rows.add(dataService);
    tbServiceList.draw();
  });

});

app.controller('myCtrl', function ($scope, $http, $q) {
  $scope.file_upload = "";
  angular.element(document).ready(function () {
    //$scope.searchService();
  });

  $scope.searchService = function () {
    $scope.getService().then(function (data) {
      dataService = data;

      console.log(data);

      tbServiceList.clear();
      tbServiceList.rows.add(dataService);
      tbServiceList.draw();

      hideLoading();
    });
  }

  $scope.getService = function () {
    showLoading();
    var dfrd = $q.defer();
    $http({
      method: 'GET',
      url: 'function/select.php',
      params: {
        action: "get_dashboard_service_list"
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