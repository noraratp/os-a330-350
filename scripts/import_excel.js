var json_object = [];
var tbEmployee;
var options = {
    paging: true,
    bInfo: false,
    bFilter: true,
    data: json_object,
    scrollY: "800px",
    scrollCollapse: true,
    autoWidth: true,
    columns: [{
            title: "No",
            width: "50px",
            "render": function ( data, type, full, meta ) {
                return  meta.row + 1;
            }
         } ,
        {
            title: "Pers",
            width: "20px",
            data: "pers"
        },
        {
            title: "Rank",
            width: "50px",
            data: "rank"
        },
        {
            title: "Name",
            data: "name_en"
        },
        {
            title: "Surname",
            data: "surname_en"
        },
        {
            title: "",
            data: "f_surname_en",
            width: "30px"
        },
        {
            title: "Mobile",
            data: "mobile",
            width: "70px",
        },
        {
            title: "Nickname",
            data: "nickname",
            width: "50px"
        },
        {
            title: "Name Thai",
            data: "name_th"
        }
        ,
        {
            title: "Surname Thai",
            data: "surname_th"
        }
        ,
        {
            title: "GoThaiMail",
            data: "gothaimail"
        }
    ],
}

$(document).ready(function(){
    tbEmployee = $("#tbEmployee").DataTable(options);

    $("#fileUploader").change(function(evt){
        showLoading();
        var selectedFile = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = function(event) {
            var data = event.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            json_object = [];
            workbook.SheetNames.forEach(function(sheetName) {
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var json = JSON.stringify(XL_row_object);
                json = JSON.parse(json);
                json.forEach(element => {
                    json_object.push(
                        {
                            pers: element.Pers == undefined ? 0 : element.Pers,
                            rank: element.Rank == undefined ? "" : element.Rank,
                            name_en: element.Name == undefined ? "" : element.Name,
                            surname_en: element.Surname == undefined ? "" : element.Surname,
                            f_surname_en: element.__EMPTY == undefined ? "" : element.__EMPTY,
                            mobile: element.Mobile == undefined ? "" : element.Mobile,
                            nickname: element.Nick == undefined ? "" : element.Nick,
                            name_th: element["Name -Thai"] == undefined ? element["Name-Thai"] : element["Name -Thai"],
                            surname_th: element["Surname -Thai"] == undefined ? element["Surname-Thai"] : element["Surname -Thai"],
                            gothaimail: element.GoThaiMail == undefined ? "" : element.GoThaiMail
                        }
                    )
                });
               
                tbEmployee.clear();
                tbEmployee.rows.add(json_object);
                tbEmployee.draw();
               
            });
            hideLoading();
        };
        reader.onerror = function(event) {
            showError("File could not be read! Code " + event.target.error.code);
            hideLoading();
        };
        reader.readAsBinaryString(selectedFile);
    });


});

app.controller('importCtrl', function ($scope, $http, $q) {
    angular.element(document).ready(function () {
    });

    $scope.saveData = function () {
        showLoading();
        if(json_object.length == 0) {
            hideLoading();
            showError("กรุณานำเข้าข้อมูลอย่างน้อย 1 รายการ");
            return;
        }
        $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: json_object,
                action: "insert_employee"
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