var json_list = [];
var tbTimeoff;
var options = {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'pdfHtml5',
            orientation: 'portrait',
            exportOptions: {
                columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9 ]
            },
            pageSize: 'TABLOID',
            customize: function (doc) {
                var tblBody = doc.content[1].table.body;
                doc.content[1].layout = {
                hLineWidth: function(i, node) {
                    return (i === 0 || i === node.table.body.length) ? 2 : 1;},
                vLineWidth: function(i, node) {
                    return (i === 0 || i === node.table.widths.length) ? 2 : 1;},
                hLineColor: function(i, node) {
                    return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';},
                vLineColor: function(i, node) {
                    return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';}
                };
                $('#gridID').find('tr').each(function (ix, row) {
                    var index = ix;
                    var rowElt = row;
                    $(row).find('td').each(function (ind, elt) {
                        tblBody[index][ind].border
                        if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
                            delete tblBody[index][ind].style;
                            tblBody[index][ind].fillColor = '#FFF9C4';
                        }
                        else
                        {
                            if (tblBody[index][2].text == '') {
                                delete tblBody[index][ind].style;
                                tblBody[index][ind].fillColor = '#FFFDE7';
                            }
                        }
                    });
                });
            }
        }
    ],
    paging: true,
    bInfo: false,
    bFilter: true,
    data: json_list,
    scrollY: "500px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [
        {
            title: "No.",
            width: "10px",
            className: "text-center",
            render : function ( data, type, full, meta ) {
                return  meta.row + 1;
            }
        },
        {
            title: "View",
            data: "id",
            width: "30px",
            className: "text-center",
            render: function(data, type, row, meta) {
                if (type === 'display') {
                    data = '<a href="employee_detail.php?id='+row.id+'" class="btn btn-sm btn-warning"><i class="fas fa-search"></i></a>'
                }
    
                return data;
            }
        },
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
            title: "Year",
            width: "50px",
            data: "yyyy",
            className: "text-center",
        },
        {
            title: "Total Leave (days)",
            width: "50px",
            data: "sum_days",
            className: "text-center",
        },
        {
            title: "Leave (times)",
            width: "50px",
            data: "count_sick",
            className: "text-center",
        },
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
    angular.element(document.getElementById('dvTimeoffList')).scope().onConfirmDelete(id);
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
    $scope.deletedItem = {};
    $scope.selectedYear = "";

    $scope.years = [2019, 2020, 2021, 2022, 2023];
    angular.element(document).ready(function () {
        setTimeout(function() {
            $scope.selectedYear = yyyy;
            $scope.searchTimeoff();
            $scope.$apply();
            console.log($scope.selectedYear);
        }, 100);
        
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
            params:{
                year: $scope.selectedYear
            },
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

    $scope.onConfirmDelete = function(id) {
        $scope.deletedItem = json_list.find(e=>e.id == id);
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
                    showSuccess("ลบข้อมูลสำเร็จ", false);
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
    }
    
});