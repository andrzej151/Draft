function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") return;

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=", 2);
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) parms[n] = [];
        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

var adr = parseURLParams(document.URL);


(function(){
            var app = angular.module('AppUczestnicy', []);
            app.controller('Uczestnicy', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

                $http.get('http://and-dab.cba.pl/Draft/Projekt/uczestnicy_dane.php?idproj='+adr.idproj[0] ).success(
                    function (data) {
                  
                       
                        $scope.uczestnicy = data;
                    });
            

                    }]);
    
                app.controller('Liderzy', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

              
              $http.get('http://and-dab.cba.pl/Draft/Projekt/liderzy_dane.php?idproj='+adr.idproj[0] ).success(
                    function (data) {
                        
                     
                        $scope.liderzy = data;
                    });

                    }]);
    
     app.controller('Zadania', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

                $http.get('http://and-dab.cba.pl/Draft/Zadania/zadania_projekt_dane.php?idproj='+adr.idproj[0] ).success(
                    function (data) {
                  
                        
                        $scope.zadania = data;
                    });
            

                    }]);
    
            })();
   
            


