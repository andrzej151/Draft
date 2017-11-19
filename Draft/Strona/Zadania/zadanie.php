<?php
    session_start();
    if (!isset($_GET['idzad']))
	{
        //bez nr zadania
		header('Location: ../Projekt/wszystkie_projekty.php');
		exit();
	}
$idzad=$_GET['idzad'];
 
	
	if (!isset($_SESSION['zalogowany']))
	{
        //gosc
		header('Location: ../Projekt/wszystkie_projekty.php');
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
                
                $sql="SELECT * FROM DUczestnProj, DZadanieG WHERE DUczestnProj.idproj=DZadanieG.idproj AND DUczestnProj.idusera=".$idusera." AND DZadanieG.id=".$idzad;
                
                $rezultat = $polaczenie->query($sql);
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich = $rezultat->num_rows;
				if($ile_takich>0)
				{
					           
                    
                      $sql="SELECT * FROM DLiderzy, DZadanieG WHERE DLiderzy.idproj=DZadanieG.idproj AND DLiderzy.idusera=".$idusera." AND DZadanieG.id=".$idzad;
                //echo($sql);
                    $rezultat = $polaczenie->query($sql);
				
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
                    
                        $sql="SELECT * FROM DLiderzy, DZadanieG WHERE DLiderzy.idproj=DZadanieG.idproj AND DLiderzy.idusera=".$idusera." AND DZadanieG.id=".$idzad;
                //echo($sql);
                    $rezultat = $polaczenie->query($sql);
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich>0)
                    {
                        
                    }else{
                        
                    }
				}
                else
                {
                    header('Location: wszystkie_projekty.php');
		              exit();
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
        
        
        $zadanie;
		try 
		{
            mysqli_report(MYSQLI_REPORT_STRICT);
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
                $q="SELECT * FROM DZadanieG WHERE id ='$idzad'";
                echo($q);
                $sql=mysql_query($q);
                
                while($row=mysql_fetch_assoc($sql)){ 
				$zadanie[]=$row; 
                }

                    
                    
                
                    if($zadanie[0]["status"]=="DODANO") $status=0;//do wziecia zadanie
                    else
                    if($zadanie[0]["status"]=="REALIZACJA") $status=1;//pobrane zadanie wykonywane
                    else
                    if($zadanie[0]["status"]=="WYKONANE") $status=2; // wykonane do zaakceptowania przez lidera
                    else
                    if($zadanie[0]["status"]=="ZGLOSZONE") $status=3;
                    else
                    if($zadanie[0]["status"]=="ZAKONCZONE") $status=4;//wykonane zaakceptowane przez lidera
                    else
                    if($zadanie[0]["status"]=="BEZAKCEPTACJI ") $status=5;//wykonane nie zaakceptowane przez lidera
                    else
                    if($zadanie[0]["status"]=="NIEWYKONANE") $status=6;//niewykonane do wziecia 
                    $zadanie=$zadanie[0];
				
				
                        	
				}
				

			}
			
		
		catch(Exception $e)
		{
			
		}
        
    }
        
    

?>
    <!DOCTYPE HTML>
    <html lang="pl">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Draft - Zadanie</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body >

        <div class="wrapper">
            <div class="header">
                <div id="logo" class="logo">
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
                <main>
                    <div id="zadanie" class="box">
                        <h2><?php echo($zadanie['nazwa']); ?></h2>
                        <p><?php echo($zadanie['opis']); ?></p>
                        <h3>Priorytet: <?php echo($zadanie["priorytet"]) ?></h3>
                        <h3>Dedline: <?php echo($zadanie["dedline"]) ?></h3>
                        <h3>Status: <?php echo($zadanie["status"]) ?></h3>
                        <h3>Punkty: <?php echo($zadanie["punkty"]) ?></h3>
                        <h3>Ile max osób potrzeba do realizacji: <?php echo($zadanie["ileosob"]) ?></h3>
                        <?php if($zadanie["link"]!=NULL)echo('<h3><a href="'.$zadanie["link"].    '">Dowód realizacji </a></h3>');?>
                        
                        <div class="funkcje">
                            <h3>Funkcje</h3>
                            <a href="../Projekt/projekt.php?idproj=<?php echo($zadanie["idproj"]) ?>"><button class="btn-prim">Projekt</button></a>
                            <?php
                            <a href="przyjmij_zadanie.php?idzad=<?php echo($idzad) ?>"><button class="btn-prim">Przyjmij zadanie</button></a>
                            <a href="wykonaj_zadanie.php?idzad=<?php echo($idzad) ?>"><button class="btn-suc">Zadanie Wykonane</button></a>
                            <a href="zadanie_nie_wykonane.php?idzad=<?php echo($idzad) ?>"><button class="btn-dgr">Zadanie NIE Wykonane</button></a>
                            <a href="akceptuj_zadanie.php?idzad=<?php echo($idzad) ?>"><button class="btn-suc">Akceptuj Zadanie</button></a>
                            <a href="nie_akceptuj_zadania.php?idzad=<?php echo($idzad) ?>"><button class="btn-dgr">NIE Akceptuje Zadania</button></a>
                            <a href="uwagazad.php?idzad=<?php echo($idzad) ?>"><button class="btn-dgr">Dodaj Uwagę</button></a>
                                ?>
                            
                        </div>
                        
                        
                        
                    </div>
                </main>
            </div>

        </div>


        <script src="Draft/jquery">


        </script>
        <script src="Draft/stickymenu">


        </script>
        <script src="../js/angular.min.js"></script>
        <script src="../js/app.js"></script>

        


    </body>

    </html>
