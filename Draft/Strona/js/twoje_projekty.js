(function(){
var app = angular.module('myApp', []);
    
app.controller('TwojeProjektyLider', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

    $http.get('http://and-dab.cba.pl/Draft/Projekt/wszystkie_projekty_dane_lider.php?id=14').success(
        function (data) {
            $scope.projektylider = data;
        });

    	}]);


app.controller('TwojeProjektyUczestnik', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

    $http.get('http://and-dab.cba.pl/Draft/Projekt/wszystkie_projekty_dane_uczestnik.php?id=14').success(
        function (data) {
            $scope.projektyuczestnik = data;
        });

    	}]);
})();
