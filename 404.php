<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="404Ctrl" class="card">
        <div class="card-header">
            <h3 class="card-title">
               404 Not found
            </h3>

        </div>
        <div class="card-body">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href="index.php">return to dashboard</a> or try using the search
                        form.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>