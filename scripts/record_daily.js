
var tbService;
var dataService = [];
var optionServiceTable = {
    paging: false,
    bInfo: false,
    bFilter: false,
    data: dataService,
    scrollY: "800px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [{
            title: "ทะเบียนรถ",
            data: "plate_no",
            width: "100px"
        },
        {
            title: "ยี่ห้อรถ",
            data: "brand",
            width: "250px"
        },
        {
            title: "สีรถ",
            data: "color",
            width: "50px",
        },
        {
            title: "ประเภทบริการ",
            data: "service_type"
        },
        {
            title: "รายละเอียด",
            data: "description"
        },
        {
            title: "ราคา",
            data: "price",
            render: $.fn.dataTable.render.number(',', '.', 0)
        },
        {
            title: "#",
            data: "action",
            width: "50px",
            defaultContent: "<button class='btn btn-danger'><i class='fas fa-trash'></i></button>"

        }
    ],
}

var tbSearchCustomer;
var dataCustomer = [];
var optionCustomer = {
    paging: true,
    bInfo: false,
    bFilter: true,
    lengthChange: false,
    data: dataCustomer,
    scrollY: "800px",
    scrollCollapse: true,
    autoWidth: true,
    pageLength: 5,
    columns: [{
        title: "เลือก", 
        width: "50px",
        defaultContent: "<button class='btn btn-primary'><i class='fas fa-check'></i></button>"
        },
        {
            title: "รหัส",
            data: "code",
            width: "50px"
        },
        {
            title: "ชื่อ",
            data: "firstname",
            width: "100px"
        },
        {
            title: "นามสกุล",
            data: "lastname",
            width: "100px"
        },
        {
            title: "ชื่อเล่น",
            data: "nickname",
            width: "50px",
        },
        {
            title: "เบอร์โทรศัพท์",
            data: "tel",
            width: "50px",
        }
    ],
}

$(function () {
    $('.datepicker').datepicker({
        autoclose: true,
        language: 'TH',
    });

    $('.select2').select2();

    tbService = $("#tbService").DataTable(optionServiceTable);
    $('#tbService tbody').on('click', 'button', function() {
        var data = tbService.row($(this).parents('tr')).data();
        var index = dataService.indexOf(data);
        if (index !== -1) dataService.splice(index, 1);

        tbService.clear();
        tbService.rows.add(dataService);
        tbService.draw();
    });

    tbSearchCustomer = $("#tbSearchCustomer").DataTable(optionCustomer);
    $('#tbSearchCustomer tbody').on('click', 'button', function() {
        var data = tbSearchCustomer.row($(this).parents('tr')).data();
        var index = dataCustomer.indexOf(data);
        if (index !== -1) {
            $('#modalSearchCustomer').modal("hide");
            var scope = angular.element(document.getElementById('dvForm')).scope();
            scope.onSelectCustomer(data);
        }
        else {
            showError("ไม่พบข้อมูลลูกค้าที่เลือก");
        }
    });
});

app.controller('recordDairyCtrl', function ($scope, $http, $q) {
    $scope.file_upload = "";
    $scope.create = {};
    $scope.create.service = [];
    $scope.service = {};
    $scope.vehicleList = [];
    $scope.discount = 0;
    $scope.amount = 0;
    angular.element(document).ready(function () {
    });

    $scope.addService = function () {
        console.log($scope.customer);
        if($scope.create.customer == undefined){
            showError("กรุณาเลือกลูกค้า");
            return;
        }
        
        $('#modalCreate').modal("show");
        
        $scope.getVehicle().then(function (data) {
            setTimeout(function(){
                $scope.vehicleList = data;
                $scope.$apply();
                console.log($scope.vehicleList);
            },100);
            hideLoading();
        });
    }

    $scope.searchCustomer = function () {
        $scope.getCustomer().then(function (data) {
            dataCustomer = data;

            console.log(data);

            tbSearchCustomer.clear();
            tbSearchCustomer.rows.add(dataCustomer);
            tbSearchCustomer.draw();

            $('#modalSearchCustomer').modal("show");
            
            hideLoading();
        });
    }
    

    $scope.onSelectCustomer = function(data) {
        console.log(data);

        setTimeout(function(){
            $scope.create.customer = {};
            $scope.create.customer.firstname = data.firstname;
            $scope.create.customer.lastname = data.lastname;
            $scope.create.customer.customer_id = data.id;
            $scope.create.customer.tel = data.tel;
            $scope.create.customer.contact_name = data.contact_name;
            $scope.create.customer.display = data.firstname + " " + data.lastname;
    
            $scope.create.service = [];

            $scope.$apply();
        },100);
       
    }

    $scope.getCustomer = function () {
        showLoading();
        var dfrd = $q.defer();
        $http({
            method: 'GET',
            url: 'function/select.php',
            params: {
                action: "get_customer"
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

    $scope.getVehicle = function () {
        showLoading();
        var dfrd = $q.defer();
        $http({
            method: 'GET',
            url: 'function/select.php',
            params: {
                params: {customer_id: $scope.create.customer.customer_id},
                action: "get_vehicle"
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

    $scope.onSubmitService = function() {

        setTimeout(function(){
            var vehicleData = $scope.vehicleList.find(e=>e.id == $scope.service.vehicle_id);
            if(vehicleData == undefined){
                showError("ไม่พบข้อมูลรถลูกค้า");
                return;
            }
            $scope.create.service.push(
                {
                    service_type: $scope.service.service_type,
                    description: $scope.service.description,
                    vehicle_id: $scope.service.vehicle_id,
                    price: $scope.service.price | 0,
                    plate_no: vehicleData.plate_no,
                    brand: vehicleData.brand,
                    color: vehicleData.color,
                    discount:0,
                    amount: $scope.service.price | 0,
                    id: uuidv4()
                }
            );

            $scope.service = {};

            dataService = $scope.create.service;
            $scope.create.discount = 0;
            $scope.create.amount = 0;
            $scope.create.service.forEach(element => {
                $scope.discount += element.discount;
                $scope.amount += element.amount;
            });

            tbService.clear();
            tbService.rows.add(dataService);
            tbService.draw();

            $scope.$apply();

            $('#modalCreate').modal("hide");
        },100);
       
    }

    $scope.saveData = function () {
        if($scope.service_date == undefined || $scope.service_date == "") {
            showError("กรุณาเลือกวันที่");
            return;
        }
        if($scope.create.customer == undefined || $scope.create.customer_id == "") {
            showError("กรุณาเลือกลูกค้า");
            return;
        }
        if($scope.create.service.length == 0) {
            showError("กรุณากรอกการบริการ อย่างน้อย 1 รายการ");
            return;
        }
        console.log($scope.create)
        $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: $scope.create,
                service_date: $scope.service_date,
                discount: $scope.discount,
                amount: $scope.amount,
                action: "insert_service"
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.status == 200) {
                hideLoading();
                showSuccess();
            }
            else {
                hideLoading();
                showError(response.data.message);
            }
        },
            function (response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
    }


});