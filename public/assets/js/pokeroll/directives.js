app.directive('dioAutocomplete', function(){
  return {
    restrict: "EAC",
    link: function(scope, element, attrs){
      
      var dataprovider = [];
      
      scope.$watch(attrs.dioAutocompleteDataprovider, function(value){
        dataprovider = value;
      });

      scope.$watch(attrs.dioAutocompleteSource, function(value){
        for(var i = 0; i < dataprovider.length; i++){
          if(dataprovider[i].indexOf(value) != -1){
            alert(dataprovider[i]);
            break;
          }
        }
      });

    }
  };
});

app.directive('dioWidgetBuyinlist', function(){
  var val = {
    restrict: "EAC",
    //scope: {},
    link: function($scope, $element, $attrs){
      $element.bind('click', function(event){
        event.preventDefault();
        event.stopPropagation();
        console.log($attrs);
        $scope.getBuyins($attrs.sessionId);
      });
    },
    controller: function($scope, BuyinsService, $attrs){
      $scope.getBuyins = function(sessionId){
        $scope.buyins = BuyinsService.query({sessionId: sessionId});
      };
    }
  };
  return val;
});