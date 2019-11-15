var app = angular.module('myApp', []);
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


$(document).ready(function() {
    $('#loading_panel').hide();
});

function showLoading() {
    $('#loading_panel').show();
}

function hideLoading() {
    $('#loading_panel').hide();
}

function showSuccess(msg) {
    $("#modalSuccess").modal("show");
    if (msg != "") {
        $("#txtSuccessMessage").html(msg);
    }
}

function showError(msg) {
    $("#modalError").modal("show");
    if (msg != "") {
        $("#txtErrorMessage").html(msg);
    }
}