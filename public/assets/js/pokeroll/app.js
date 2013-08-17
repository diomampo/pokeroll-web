var app = angular.module('pokeroll',[])
  .config(function($routeProvider, $locationProvider) {

  //init routes
  $routeProvider
  .when('/', {
    templateUrl: 'assets/js/pokeroll/index.tpl.html',
    controller: 'MainController'
  })
  .when('/sessions', {
    templateUrl: 'assets/js/pokeroll/sessions/sessions.tpl.html',
    controller: 'SessionsController'
  })
  .otherwise({redirectTo: '/sessions'});
  // configure html5 to get links working on jsfiddle
  $locationProvider.html5Mode(true);
});

//configuration variables
app.value('configuration', function(){
  return {
    APP_DIR: 'assets/js/pokeroll/',
    API_ENDPOINT: 'api/'
  };
});

app.controller('MainController', function($scope) {

});