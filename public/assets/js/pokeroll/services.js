app.factory('SessionsService', ['$resource', function($resource) {
  return $resource('api/sessions/:sessionId', {}, {
    update: {method: 'PUT'}
  });
}]);

app.factory('BuyinsService', ['$resource', function($resource) {
  return $resource('api/sessions/:sessionId/buyins/:buyinId', {}, {
    update: {method: 'PUT'}
  });
}]);

app.factory('LocationsService', ['$resource', function($resource) {
  return $resource('api/locations/:locationId', {}, {
    update: {method: 'PUT'}
  });
}]);