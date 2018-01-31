<?php
  	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/');
		exit();
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

    <body ng-app='App'>

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

                <div ng-controller='Projektlider'>
                   <div class="wyszukiwarka">
                       <h1>Twoje projekty w których jesteś liderem </h1>
                        <input type="text" placeholder="Czego szukasz ogolnie?" ng-model="wyszukiwarkalider">
                   </div>
                   <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po nazwie?" ng-model="wyszukiwarkalider.nazwa">
                   </div>
                    <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po statusie?" ng-model="wyszukiwarkalider.status">
                   </div>
                   
                   <div class="projekt" ng-repeat="projekt in projektylider| filter : wyszukiwarkalider">
                        <h3>Nazwa: {{ projekt.nazwa }}</h3>
                        <p>Cel: {{ projekt.opisK }}</p>
                        <div class="statystyka">
                            Punkty: {{ projekt.punkty }}/{{ projekt.punktyWydane }}<br/>
                            Status: {{ projekt.status }}<br/>
                            Data załorzenia: {{ projekt.DataZl }}
                        </div>

                        <a href="projekt.php?idproj={{ projekt.id }}">
                            <button class="btn-prim">
                                Zobacz projekt!
                            </button>
                        </a>   
                                
                   </div>
                </div>
                <div>
                <div style="clear:both;">
                    
                </div>
                
                 <div ng-controller='Projektuczestnik'>
                   <div class="wyszukiwarka">
                       <h1>Twoje projekty w których jesteś Uczestnikiem </h1><br/>
                        <input type="text" placeholder="Czego szukasz ogolnie?" ng-model="wyszukiwarkauczestnik">
                   </div>
                   <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po nazwie?" ng-model="wyszukiwarkauczestnik.nazwa">
                   </div>
                    <div class="wyszukiwarka">                       
                        <input type="text" placeholder="Szukasz po statusie?" ng-model="wyszukiwarkauczestnik.status">
                   </div>
                   
                   <div class="projekt" ng-repeat="projekt in projektyuczestnik| filter : wyszukiwarkauczestnik">
                        <h3>Nazwa: {{ projekt.nazwa }}</h3>
                        <p>Cel: {{ projekt.opisK }}</p>
                        <div class="statystyka">
                            Punkty: {{ projekt.punkty }}/{{ projekt.punktyWydane }}<br/>
                            Status: {{ projekt.status }}<br/>
                            Data załorzenia: {{ projekt.DataZl }}
                        </div>

                        <a href="projekt.php?idproj={{ projekt.id }}">
                            <button class="btn-prim">
                                Zobacz projekt!
                            </button>
                        </a>   
                      ul>li*5>lorem          
                   </div>
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
          <script src="../js/twoje_projekty.js">
        </script>
        
        


    </body>

    </html>
