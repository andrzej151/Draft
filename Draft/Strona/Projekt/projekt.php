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
            //statusy
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                
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
        
        
        $projekt;
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
                $sql=mysql_query("SELECT * FROM DProjekty WHERE id ='$idprojektu'");
                while($row=mysql_fetch_assoc($sql)){ 
				$projekt[]=$row; 
                    
                
                    if($projekt[0]["status"]=="DOTOWANIE") $status=0;
                    else
                    if($projekt[0]["status"]=="REALIZACJA") $status=1;
                    else
                    if($projekt[0]["status"]=="ZAKONCZONY") $status=2;
                    else
                    if($projekt[0]["status"]=="ZAWIESZONY") $status=3;
                    else
                    if($projekt[0]["status"]=="ZGŁOSZONY") $status=4;
                    
				}
				
                        	
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
        <title>Draft - Projekt</title>
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
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#logo">
                                <li>Tytuł</li>
                            </a>
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#opis">
                                <li>Opis</li>
                            </a>
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#uczestnicy">
                                <li>Uczestnicy</li>
                            </a>
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#zadania">
                                <li>Zadania</li>
                            </a>
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#uwagi">
                                <li>Uwagi</li>
                            </a>
                            <a href="projekt.php?idproj=<?php echo($idprojektu);?>#zakonczenie">
                                <li>Zakonczenie</li>
                            </a>
                        </ul>

                        <ul>
                            <h4>AKCJE</h4>
                            <?php 
                                    if($b_urzytkownik){
                                        if($status<2)
                                        {
                                            echo( '<a href="../Transakcje/dotuj.php?idproj='.$idprojektu.'">
                                               <li>Dotuj Projekt</li>
                                            </a>');
                                        }
                                    }
                                ?>
                            <?php 
                                    if($b_urzytkownik){
                                        if($status<2)
                                        {
                                            echo( '<a href="../Uwagi/uwaga_do_projektu.php?idproj='.$idprojektu.'">
                                            <li>Uwagi do Projektu</li>
                                            </a>');
                                        }
                                    }
                                ?>
                            <?php 
                                    if($b_urzytkownik){
                                        if($status<2)
                                        {
                                            if(!$b_uczestnik){
                                                 echo( '<a href="dolacz.php?idproj='.$idprojektu.'">
                                                    <li>Dołacz do Projektu</li>
                                                    </a>');
                                            }else
                                            {
                                                echo( '<a href="odejdz.php?idproj='.$idprojektu.'">
                                                    <li>Odejdź z Projektu</li>
                                                    </a>');
                                            }
                                        }
                                    }?>
                            <?php 
                                    if($b_lider){
                                        if($status<2)
                                        {
                                             echo( '<a href="edytuj_projekt.php?id='.$idprojektu.'">
                                            <li>Edytuj Projekt</li>
                                            </a>');}};
                                        ?>
                            <?php 
                                    if($b_lider){
                                        if($status<2)
                                        {
                                             echo( '<a href="dodaj_lidera.php?idproj='.$idprojektu.'">
                                            <li>Dodaj lidera</li>
                                            </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status==0)
                                        {
                                             echo( '<a href="etap_realizacja.php?idproj='.$idprojektu.'"><li>Przejdź do realizacji</li>
                                                </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status==1)
                                        {
                                             echo( '<a href="etap_dotowanie.php?idproj='.$idprojektu.'"><li>Przejdź do dotowania</li>
                                                </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status==1)
                                        {
                                             echo( '<a href="etap_zakoncz.php?idproj='.$idprojektu.'"><li>Zakończ Projekt</li>
                                                </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status<2)
                                        {
                                             echo( '<a href="etap_zawies.php?idproj='.$idprojektu.'"><li>Zawieś Projekt</li>
                                                </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status==1)
                                        {
                                             echo( '<a href="stworz_spotkanie.php?idproj=  '.$idprojektu.'"><li>Stwórz Spotkanie</li>
                                                </a>');}};
                                ?>
                            <?php 
                                    if($b_lider){
                                        if($status==1)
                                        {
                                             echo( '<a href="../Zadania/stworz_zadanie.php?idproj='.$idprojektu.'"><li>Stwórz Zadanie</li>
                                                </a>');}};
                                ?>
                        </ul>
                    </div>

                </nav>
            </div>
            <div class="content">
                <main>
                    <div id="tytul" class="box">
                        <div class="box2">
                            <h2>Nazwa:
                                <?php 
                                echo($projekt[0]["nazwa"]);
                                ?>
                            </h2>
                            <h4>
                                <?php 
                                echo($projekt[0]["status"]);
                                ?>
                            </h4>
                        </div>
                        <div class="box2">
                            <h4>Punkty:
                                <?php 
                                echo($projekt[0]["punkty"]."/".$projekt[0]["punktyWydane"]);
                                
                                ?>
                            </h4>
                            <h4>Data utworzenia:
                                <?php 
                                echo($projekt[0]["DataZl"]);
                                ?>
                            </h4>
                            <h4>Data zakonczenia:
                                <?php 
                                if($projekt[0]["nazwa"]!=NULL)
                                echo($projekt[0]["nazwa"]);
                                ?>
                            </h4>

                        </div>
                    </div>
                    <div id="opis" class="box">
                        <div class="box1">
                            <h3>Cel:</h3>
                            <p>
                                <?php 
                                echo($projekt[0]["opisK"]);
                                ?>
                            </p>
                        </div>
                        <div class="box1">
                            <h3>Opis:</h3>
                            <p>
                                <?php 
                                echo($projekt[0]["opisD"]);
                                ?>
                            </p>
                        </div>
                        <div class="box1">
                            <a href="<?php 
                                echo($projekt[0][" linkOpis "]);
                                ?>">
                                <h3>Link do innych szczegółow</h3>
                            </a>
                        </div>
                        <div class="box1">
                            <h3>Benefity</h3>
                            <p>
                                <?php 
                                echo($projekt[0]["benefityOpis"]);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div id="uczestnicy">
                        <div ng-app='AppUczestnicy'>

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
                                        <input type="text" placeholder="Kogo szukasz?" ng-model="wyszukiwarkauczestnik">
                                    </div>


                                    <div class="projekt" ng-repeat="uczestnik in uczestnicy| filter : wyszukiwarkauczestnik">
                                        <h3>Imię: {{ uczestnik.imie }}</h3>
                                        <h3>Nazwisko: {{ uczestnik.nazwisko }}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>






                    <div id="zadania" class="box">
                        <h3>Zadania</h3>
                        <tabela></tabela>
                    </div>
                    <div id="uwagi" class="box">
                        <h3>Uwagi</h3>
                    </div>
                    <div id="zakonczenie" class="box">
                        <h3>podsumowanie Projektu:</h3>
                    </div>

                </main>
            </div>

        </div>


        <script src="Draft/jquery">


        </script>
        <script src="Draft/stickymenu">


        </script>
        <script src="../js/angular.min.js"></script>

        <script src="../js/uczestnicy.js"></script>



    </body>

    </html>
