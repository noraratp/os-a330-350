<?php include("includes/config.php"); ?>
<html>

<head>
    <?php include("includes/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <?php include("includes/layout.php"); ?>
    <div ng-app="myApp" ng-controller="myCtrl" class="card">
        <div class="card-header">
          <h3 class="card-title"><?echo $PAGE_TITLE ?></h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
        </div>
      </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>
<script>
app.controller('myCtrl', function($scope, $http, $q) {
  angular.element(document).ready(function() {
        showLoading();
        setTimeout(() => {
          hideLoading();
          showSuccess("Test modal");
        }, 1000);
    });
});
</script>