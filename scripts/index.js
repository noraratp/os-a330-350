app.controller('myCtrl', function($scope, $http, $q) {
    $scope.file_upload = "";
    angular.element(document).ready(function() {
         $scope.setData();
    });
  
    $scope.setData = function() {
        $scope.getNews().then(function(data) {
          console.log(data);
          hideLoading();
      });
  
    }

    $scope.getNews = function() {
      showLoading();
      var dfrd = $q.defer();
      $http({
          method: 'GET',
          url: 'function/select.php',
          params: {
              params: {
                test: "xxx"
              },
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
    $scope.uploadFile = function() {
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
            console.log(response)
            var post_data = {id:1, firstname: "test", lastname: "insert",picture: response.data};
            $http({
                method: "post",
                url: "function/insert.php",
                data: {
                    post_data: post_data,
                    action: "update_customer"
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(response) {
              if (response.status == 200) {
                hideLoading();
                showSuccess();
              }
              else {
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

    $scope.saveData = function() {
      $scope.uploadFile().then(function(file_name) {
          console.log(file_name);
          var post_data = {id:1, firstname: "test", lastname: "insert",picture: file_name};
          $http({
            method: "post",
            url: "function/insert.php",
            data: {
                post_data: post_data,
                action: "update_customer"
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
                if (response.status == 200) {
                  hideLoading();
                  showSuccess();
                }
                else {
                  hideLoading();
                  showError(response.data.message);
                }
            },
            function(response) { // optional
                // failed
                hideLoading();
                showError(response.data.message);
            });
      });
  }


});