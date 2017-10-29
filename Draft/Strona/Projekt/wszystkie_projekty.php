<?php
require_once "../Admin/connect.php";		
	mysqli_report(MYSQLI_REPORT_STRICT);
		try 
		{

			mysql_connect($host,$db_user,$db_password); 
			mysql_select_db($db_name); 
			//$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			//$polaczenie->set_charset("utf8");
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                $sql=mysql_query("SELECT * FROM DProjekty ORDER BY DataZl DESC ");
                while($row=mysql_fetch_assoc($sql)){ 
				$output[]=$row; 
				} 
				$dane=json_encode($output);       	
				}
			}		
		catch(Exception $e)
		{
			
		}
?>
    <!DOCTYPE HTML>
    <html lang="pl">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Draft - Stwórz projekt</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body ng-app='myApp'>

        <div class="wrapper">
            <div class="header">
                <div class="logo">
                    DRAFT
                </div>
            </div>
            <div class="nav">
                <nav>
                    <ol>
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="aktualnosci.php">Aktualności</a></li>
                        <li>Projekt
                            <ul>
                                <li><a href="../Projekt/stworz_projekt.php">Stwórz</a></li>
                                <li><a href="../Projekt/twoje_projekty.php">Twoje</a></li>
                                <li><a href="../Projekt/wszystkie_projekty.php">Wszystkie</a></li>
                            </ul>
                        </li>
                        <li><a href="../Zadania/twoje_zadania.php">Zadania</a></li>
                        <li><a href="../Baza%20wiedzy/baza-wiedzy.php">Baza Wiedzy</a></li>
                        <li><a href="../Transakcje/twoje_transakcje.php">Transakcje</a></li>
                        <li><a href="../Info/kontakt.php">Kontakt</a></li>
                        <li><a href="../Rejestracja/logout.php">Wyloguj sie</a></li>
                    </ol>
                </nav>
            </div>

            <div class="content">

                <div ng-controller='ProjCon'>
                   <div class="wyszukiwarka">
                       <h1>Wszystkie Projekty</h1><br/>
                        <input type="text" placeholder="Czego szukasz ogolnie?" ng-model="wyszukiwarka">
                   </div>
                   <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po nazwie?" ng-model="wyszukiwarka.nazwa">
                   </div>
                    <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po statusie?" ng-model="wyszukiwarka.status">
                   </div>
                   
                   <div class="projekt" ng-repeat="projekt in projekty| filter : wyszukiwarka">
                        <h3>Nazwa: {{ projekt.nazwa }}</h3>
                        <p>Cel: {{ projekt.opisK }}</p>
                        <div class="statystyka">
                            Punkty: {{ projekt.punkty }}/{{ projekt.punktyWydane }}<br/>
                            Status: {{ projekt.status }}<br/>
                            Data załorzenia: {{ projekt.DataZl }}
                        </div>

                        <a href="projekt?id={{ projekt.id }}">
                            <button class="btn-prim">
                                Zobacz projekt!
                            </button>
                        </a>   
                                
                   </div>
                    


                </div>
            </div>
        </div>

        <script src="Draft/jquery">


        </script>
        <script src="Draft/stickymenu">


        </script>
        <script src="../js/angular.min.js">


        </script>
        <script>
            var app = angular.module('myApp', []);

            app.controller('ProjCon', ['$scope', '$filter', function($scope, $filter) {
                $scope.projekty = <?php echo $dane;?>;
            }]);

        </script>


    </body>

    </html>
