(function(){
var app = angular.module('myApp', []);
app.controller('WszystkieProjekty', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

    $http.get('http://and-dab.cba.pl/Draft/Projekt/wszystkie_projekty_dane.php').success(
        function (data) {
            $scope.projekty = data;
        });

    	}]);
})();
