app.controller('SessionsController', function($scope, $http) {

  $http.get('api/sessions').success(function(data){
    $scope.sessions = data;
  });

  $http.get('api/locations').success(function(data){
    $scope.locations = data;
  });

  $scope.add = function() {
    var item = {
      location: $scope.location,
      game:$scope.game,
      start_time:$scope.start_time,
      buyins: [{amount:$scope.buyin}],
      end_time:$scope.end_time,
      cashout:$scope.cashout
    };
    $http.post('api/sessions', item)
      .success(function(data){
        $scope.sessions.push(data);
      }
    );
  };
});