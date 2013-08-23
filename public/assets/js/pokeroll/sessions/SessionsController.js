app.controller('SessionsController', function($scope, SessionsService, LocationsService) {

  /*
    A value object that we can bind to
    within our templates.
  */
  $scope.session = {};

  /*
    A collection of value objects used when binding.
    In this case the data is coming from our SessionsService,
    which is injected. This will make it nice and reusable
    inside other controllers.
  */
  $scope.sessions = SessionsService.query();

  $scope.locations = LocationsService.query();

  $scope.add = function(item) {
    
    //This is interesting because we need to send
    //a list of buyins, but I have no clue how to
    //setup the ng-model for this type of structure.
    item.buyins = [{amount:item.buyin}];

    //Our REST API returns the saved object on post
    SessionsService.save(item, function(data){
      $scope.sessions.push(data);
    });

  };
});