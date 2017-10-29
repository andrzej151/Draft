<?php
    session_start();
    if (!isset($_GET['id']))
	{
        //bez nr projektu
		header('Location: wszystkie_projekty.php');
		exit();
	}
$idprojektu=$_GET['id'];
 
	
	if (!isset($_SESSION['zalogowany']))
	{
        //gosc
		$b_gosc=true;
        $b_urzytkownik=false;
        $b_uczestnik=false;
        $b_lider=false;
	}else{
        //zalogowany
        require_once "../Admin/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                $idprojektu=$_GET['id'];
                $idusera=$_SESSION['id'];
                $rezultat = $polaczenie->query("SELECT idproj FROM DUczestnProj WHERE idproj='$idprojektu' AND idusera='$idusera'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich = $rezultat->num_rows;
				if($ile_takich>0)
				{
					           
                    
                    $rezultat = $polaczenie->query("SELECT idproj FROM DLiderzy WHERE idproj='$idprojektu' AND idusera='$idusera'");
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich>0)
                    {
                        $b_gosc=true;
                        $b_urzytkownik=true;
                        $b_uczestnik=true;
                        $b_lider=true;
                    }
                    else
                    {
                        $b_gosc=true;
                        $b_urzytkownik=true;
                        $b_uczestnik=true;
                        $b_lider=false;

                    }
				}
                else
                {
                    $b_gosc=true;
                    $b_urzytkownik=true;
                    $b_uczestnik=false;
                    $b_lider=false;
                    
                }
				
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
        
    }
        
    

?>
    <!DOCTYPE HTML>
    <html lang="pl">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Draft - Projekt</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body ng-app='myApp'>

        <div class="wrapper">
            <div class="header">
                <div id="logo" class="logo">
                    DRAFT
                </div>
            </div>
            <div class="nav">
                <nav>
                    <ol>
                       <?php
                        if($b_urzytkownik){
                            echo('
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
                                <li><a href="../Rejestracja/logout.php">Wyloguj sie</a></li>'
                                );
                        }else{
                            echo('
                                <li><a href="../Draft/index">Strona główna</a></li>
                                <li><a href="#">O Projekcie</a></li>
                                <li><a href="#">Projekty</a></li>
                                <li><a href="#">Kontakt</a></li>'
                                );
                        }
                        ?>
                        
                    </ol>
                    <div id="navbox">
                        
                            <ul>
                               <h4>NAWIGACJA</h4>
                                <a href="projekt#tytul?id=<?php echo($idprojektu);?>">
                                    <li>Tytuł</li>
                                </a>
                                <a href="projekt#opis?id=<?php echo($idprojektu);?>">
                                    <li>Opis</li>
                                </a>
                                <a href="projekt#uczestnicy?id=<?php echo($idprojektu);?>">
                                    <li>Uczestnicy</li>
                                </a>
                                <a href="projekt#zadania?id=<?php echo($idprojektu);?>">
                                    <li>Zadania</li>
                                </a>
                                <a href="projekt#uwagi?id=<?php echo($idprojektu);?>">
                                    <li>Uwagi</li>
                                </a>
                                <a href="projekt#zakonczenie?id=<?php echo($idprojektu);?>">
                                    <li>Zakonczenie</li>
                                </a>
                            </ul>
                        
                            <ul>
                               <h4>AKCJE</h4>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                                <a href="">
                                    <li></li>
                                </a>
                            </ul>
                        </div>
                    
                </nav>
            </div>
            <div class="content">
                <main>
                    <div id="tytul">
                        <div class="box2">
                            <h2>nazwa</h2> 
                            <h4>status</h4>
                        </div>
                        <div class="box2">
                            <h4>Punkty: </h4>
                            <h4>Data utworzenia:</h4>
                            <h4>Data zakonczenia:</h4>
                        </div>
                    </div>
                    <div id="opis">
                        <div class="box1">
                            <h3>Cel:</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus molestiae est libero labore illo. Amet vero, sunt aperiam eveniet dolores quasi ex quisquam ducimus doloremque eius, dicta nemo quos unde.</p>
                        </div>
                        <div class="box1">
                            <h3>Opis:</h3>
                            <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem repudiandae eos recusandae voluptatibus optio aut! Tempore velit dolores sit, officia non quod alias, deleniti, qui porro magni commodi, quis praesentium?</span>
                            <span>Eaque nihil eligendi eius, non ab ea similique cupiditate iure dolor odio facilis, quos quis. Rerum dolor eaque, explicabo minima inventore vero suscipit eveniet natus corporis expedita fugiat incidunt ducimus!</span>
                            <span>Voluptates magni, omnis non, a itaque cupiditate sunt! Repudiandae delectus at numquam tempora placeat nemo distinctio dicta est enim, debitis ipsa, dolores iste ipsam accusamus ratione a magnam, quasi unde!</span></p>
                        </div>
                        <div class="box1">
                            <a href="">
                                <h3>Link do innych szczegółow</h3>
                            </a>
                        </div>
                        <div class="box1">
                            <h3>Benefity</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae assumenda veniam iusto, eligendi animi officiis minus? Esse quibusdam asperiores sunt, cupiditate, ab, dignissimos quo officia id delectus possimus, eos voluptas.</p>
                        </div>
                    </div>
                    <div id="uczestnicy">
                        <h3>Liderzy</h3>
                        <div class="box3">
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                        </div>
                        <h3>Uczestnicy</h3>
                        <div class="box3">
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                            <div class="osoba"></div>
                        </div>
                    </div>
                    <div id="zadania">
                        <h3>Zadania</h3>
                        <tabela></tabela>
                    </div>
                    <div id="uwagi">
                        <h3>Uwagi</h3>
                    </div>
                    <div id="zakonczenie">
                        <h3>podsumowanie Projektu:</h3>
                    </div>
                    
                </main>
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
                $scope.projekty = ;
            }]);

        </script>


    </body>

    </html>
