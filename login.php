<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="includes/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="includes/dist/css/adminlte.css">
    <!-- Google Font: Source Sans Pro -->

</head>

<body class="hold-transition login-page" ng-app="myApp" ng-controller="myCtrl">
    <div class="login-box">
        <div class="login-logo">
            <b>OS-A330-350</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="function/login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="username" ng-model="username" name="username"
                            placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password" ng-model="password"
                            ng-enter="onLogin()" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="button" class="btn btn-primary btn-block" ng-click="onLogin()">Sign
                                In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <div class="wrap" id="loading_panel" style="z-index:9999">
        <div class="loading">
            <div class="bounceball"></div>
            <div class="text">กำลังค้นหาข้อมูล โปรดรอสักครู่</div>
        </div>
    </div>
    <!-- Modal HTML -->
    <div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success" style='color:white'>
                    Register successfully
                </div>
                <div class="modal-body text-center">
                    <b style="color:green">Register successfully</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="document.location.reload(true)">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalError" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger" style='color:white'>
                    เกิดข้อผิดพลาด
                </div>
                <div class="modal-body text-center">
                    <b style="color:red" id='txtErrorMessage'>เกิดข้อผิดพลาด</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="includes/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- overlayScrollbars -->
    <script src="includes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="includes/dist/js/adminlte.js?t=<?=time()?>"></script>
    <script src="includes/dist/js/angularjs.js?t=<?=time()?>"></script>
    <script src="includes/dist/js/site.js?t=<?=time()?>"></script>
    <script src="includes/plugins/angular-paging/paging.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="includes/dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="includes/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="includes/plugins/raphael/raphael.min.js"></script>
    <script src="includes/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="includes/plugins/jquery-mapael/maps/usa_states.min.js"></script>

    <!-- ChartJS -->
    <!-- <script src="includes/plugins/chart.js/Chart.min.js"></script> -->

    <!-- PAGE SCRIPTS -->
    <!-- <script src="includes/dist/js/pages/dashboard2.js"></script> -->
</body>

<script>
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
}

function showError(msg) {
    $("#modalError").modal("show");
    if (msg != "") {
        $("#txtErrorMessage").html(msg);
    }
}
app.controller('myCtrl', function($scope, $http, $window, $q) {
    $scope.username = ""
    $scope.password = ""
    $scope.onLogin = function() {
        showLoading();

        if ($scope.username == "") {
            showError("กรุณาระบุ Username");
            hideLoading();
            return
        }
        if ($scope.password == "") {
            showError("กรุณาระบุ Password");
            hideLoading();
            return
        }
        $http({
            method: "post",
            url: "function/login.php",
            data: {
                username: $scope.username,
                password: $scope.password,
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
                hideLoading();
                if (response.status == 200) {
                    $window.location.href = 'index.php';
                } else {
                    showError(response);
                }

            },
            function(response) { // optional
                // failed
                hideLoading();
                showError("Username หรือ Password ไม่ถูกต้อง !");
            });

    }

    $scope.onRegister = function() {
        $('#modalCreate').modal('show');
    }
    $scope.validateMedia = function() {
        var dfrd = $q.defer();
        $http({
            method: 'get',
            url: 'function/check_user.php',
            params: {
                username: $scope.create.username
            }
        }).then(function successCallback(response) {
            console.log(response.data);
            dfrd.resolve(response.data);
        })
        return dfrd.promise;
    }
    $scope.onInsert = function() {
        showLoading();
        if ($(".form-control").hasClass("required-element")) {
            hideLoading();
            showError("กรุณาตรวจสอบข้อมูลให้ครบถ้วน");
            return;
        }
        $scope.validateMedia().then(function(data) {
            if (!data) {
                $scope.create.type = 'user'
                $http({
                    method: "post",
                    url: "function/insert_register.php",
                    data: {
                        post_data: $scope.create,
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(response) {
                        hideLoading();
                        showSuccess("Register successfully. Please login again");
                    },
                    function(response) { // optional
                        // failed
                        hideLoading();
                        showError(response);
                    });
            } else {
                hideLoading();
                showError("Username : " + $scope.create.username + " มีแล้วในระบบ");
            }
        });

    }

});
</script>

</html>