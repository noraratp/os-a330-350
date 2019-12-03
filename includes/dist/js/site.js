var app = angular.module('myApp', ['angularUtils.directives.dirPagination']);
angular.module('myApp').directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter, {
                        'event': event
                    });
                });

                event.preventDefault();
            }
        });
    };
});

app.run(function ($rootScope, $templateCache) {
    $rootScope.$on('$viewContentLoaded', function () {
        $templateCache.removeAll();
    });
});

app.directive('numbersOnly', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});

app.directive("fileInput", function($parse) {
    return {
        link: function($scope, element, attrs) {
            element.on("change", function(event) {
                var files = event.target.files;
                //console.log(files[0].name);  
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    }
});


var today = new Date();
var yyyy;
var dd;
var mm;
$(document).ready(function() {
    $('#loading_panel').hide();
    var item = $.fn.dataTable.tables();

    setTimeout(() => {
        for (var i = 0; i < item.length; i++) {
            item[i].classList.add("table-column-header");
        }
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    }, 1000);
    
    
    dd = today.getDate();
    mm = today.getMonth() + 1;

    yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    today = yyyy + '/' + mm + '/' + dd;
});

$(document).on('shown.bs.modal', function (e) {
    setTimeout(() => {
        var item = $.fn.dataTable.tables();
        for (var i = 0; i < item.length; i++) {
            item[i].classList.add("table-column-header");
        }
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    }, 500);
});
$(document).on('click', 'li', function (event) {
    setTimeout(() => {
        var item = $.fn.dataTable.tables();
        for (var i = 0; i < item.length; i++) {
            item[i].classList.add("table-column-header");
        }
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    }, 500);
});
function showLoading() {
    $('#loading_panel').show();
    
}

function hideLoading() {
    $('#loading_panel').hide();
   
}

function showSuccess(msg, reload) {
    $("#modalSuccess").modal("show");
    if (msg != "") {
        $("#txtSuccessMessage").html(msg);
    }
    if(reload){
        $('#btnReloadSuccess').show();
        $('#btnSuccess').hide();
    } else {
        $('#btnSuccess').show();
        $('#btnReloadSuccess').hide();
    }
}
function showError(msg) {
    $("#modalError").modal("show");
    if (msg != "") {
        $("#txtErrorMessage").html(msg);
    }
}
function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }