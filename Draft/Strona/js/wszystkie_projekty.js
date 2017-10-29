var pobierzProjekty = function () {
    var ret;
        $.ajax({
            type: 'GET',
            url: 'http://and-dab.cba.pl/Draft/Projekt/wszystkie_projekty_dane.php',
            dataType: "json",
            success: function (data) {
                ret = data;

            }
        });
    return ret;
}

var app = angular.module('myApp', []);
app.controller('ProjCon', ['$scope', '$filter', function ($scope, $filter) {
$scope.projekty = pobierzProjekty;
    	}]);


