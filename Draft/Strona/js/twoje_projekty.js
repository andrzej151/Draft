

(function(){
            var app = angular.module('App', []);
            app.controller('Projektlider', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

                $http.get('http://and-dab.cba.pl/Draft/Projekt/twoje_projekty_dane_lider.php' ).success(
                    function (data) {
                  
                       
                        $scope.projektylider = data;
                    });
            

                    }]);
    
                app.controller('Projektuczestnik', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

              
              $http.get('http://and-dab.cba.pl/Draft/Projekt/twoje_projekty_dane_uczestnik.php' ).success(
                    function (data) {
                        
                     
                        $scope.projektyuczestnik = data;
                    });

                    }]);
    
  
    
            })();
   
            


