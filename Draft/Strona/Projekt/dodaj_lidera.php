<?php
    session_start();
    if (!isset($_GET['idproj']))
	{
        //bez nr projektu
		header('Location: wszystkie_projekty.php');
		exit();
	}
    $idprojektu=$_GET['idproj'];
 
	
	if (!isset($_SESSION['zalogowany']))
	{
        
		header('Location: projekty.php?id='.$idprojektu);
		exit();
	}else{
        //zalogowany
        require_once "../Admin/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
            //statusy
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                
                    $idusera=$_SESSION['id'];
                  
        
                
                    $sql= "SELECT idproj FROM DLiderzy WHERE idproj=".$idprojektu." AND idusera=".$idusera;
                    $rezultat = $polaczenie->query($sql);
          
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich>0)
                    {
                      ////DODO sprawdzenie aby nie dodac 2 tych samych liderow
                        //lider projektu
                        if (isset($_GET['iduczestnika']))
	                   {
                            $nowylider=$_GET['iduczestnika'];
                            $rezultat = $polaczenie->query("SELECT idproj FROM DUczestnProj WHERE idproj='$idprojektu' AND idusera='$nowylider'");
				
                            if (!$rezultat) throw new Exception($polaczenie->error);

                            $ile_takich = $rezultat->num_rows;
                            if($ile_takich>0)
                            {
                                     $rezultat = $polaczenie->query("INSERT INTO `DLiderzy`(`idproj`, `idusera`) VALUES ('$idprojektu','$nowylider')");
				
                                    if (!$rezultat) throw new Exception($polaczenie->error);
                                    
                                    header('Location: dodaj_lidera.php?idproj='.$idprojektu);
		                              exit();  
                                    
                            }
                        }
                    }
                    
				
                }
                
				
				
				$polaczenie->close();
			
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

    <body ng-app='AppUczestnicy'>

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
                </nav>
            </div>


            <div class="content">
                <main>
                    <div ng-controller='Liderzy'>
                        
                          <div class="box">
                              <div class="wyszukiwarka">
                                <h1>Liderzy</h1><br/>
                                <input type="text" placeholder="Kogo szukasz?" ng-model="wyszukiwarkalider">
                            </div>

                            <div class="projekt" ng-repeat="lider in liderzy| filter : wyszukiwarkalider">
                                <h3>Imię: {{ lider.imie }}</h3>
                                <h3>Nazwisko: {{ lider.nazwisko }}</h3>

                            </div>

                       
                        </div>
                    </div>
                        
                     <div ng-controller='Uczestnicy'>    
                        <div class="box">
                            <div class="wyszukiwarka">
                                <h1>Uczestnicy</h1><br/>
                                <input type="text" placeholder="Kogo szzukasz?" ng-model="wyszukiwarkauczestnik">
                            </div>


                            <div class="projekt" ng-repeat="uczestnik in uczestnicy| filter : wyszukiwarkauczestnik">
                                <h3>Imię: {{ uczestnik.imie }}</h3>
                                <h3>Nazwisko: {{ uczestnik.nazwisko }}</h3>


                                <a href="dodaj_lidera.php?idproj={{idproj}}&iduczestnika={{uczestnik.id}}">
                            <button class="btn-prim">
                                Dodaj jako lidera!
                            </button>
                        </a>

                            </div>

                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="Draft/jquery">


        </script>
        <script src="Draft/stickymenu"></script>


        <script src="../js/angular.min.js"></script>

        <script src="../js/uczestnicy.js"></script>
       



    </body>

    </html>
