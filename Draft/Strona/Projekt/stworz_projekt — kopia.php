<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/index');
		exit();
	}
	

	if (isset($_POST['nazwa']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nazwy
		$nazwa = $_POST['nazwa'];
        
		//Sprawdzenie długości nazwy
		if ((strlen($nazwa)<3) || (strlen($nazwa)>220))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwa']="nazwa musi posiadać od 3 do 220 znaków!";
		}
        
        //Sprawdź poprawność opisu k
		$opisk = $_POST['opisk'];
        
		//Sprawdzenie długości nazwy
		if ((strlen($opisk)<3) || (strlen($opisk)>220))
		{
			$wszystko_OK=false;
			$_SESSION['e_opisk']="cel musi posiadać od 3 do 220 znaków!";
		}
        
		$opisd = $_POST['opisd'];
        
        //Sprawdź poprawność linku
		$link = $_POST['link'];
        
		//Sprawdzenie długości linku
		if ((strlen($link)<3) || (strlen($link)>220))
		{
			$wszystko_OK=false;
			$_SESSION['e_link']="link musi posiadać od 3 do 220 znaków!";
		}
        
        $benefity = $_POST['benefity'];
        $id = $_SESSION['id'];
     
		//Bot or not? Oto jest pytanie!
		$sekret = "6LftLzYUAAAAACVllnwQoqMjIATU09zEoVr7BydL";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nazwa'] = $nazwa;
        $_SESSION['fr_opisk'] = $opisk;
        $_SESSION['fr_opisd'] = $opisd;
		$_SESSION['fr_link'] = $link;
		$_SESSION['fr_benefity'] = $benefity;
	
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
                $rezultat = $polaczenie->query("SELECT id FROM DProjekty WHERE nazwa='$nazwa'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nazw = $rezultat->num_rows;
				if($ile_takich_nazw>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nazwa']="Istnieje już projekt o takiej nazwie";
				}
				
				if ($wszystko_OK==true)
				{
                    
                    
					if ($polaczenie->query("INSERT INTO DProjekty VALUES (NULL, '$nazwa', '$opisk', '$opisd','$link', '$benefity', 0, 0, NULL, 'DOT', NULL, NULL)"))
					{
                        $dane = $polaczenie->query("SELECT id FROM `DProjekty`  WHERE nazwa='$nazwa'" ); 
				        $dane = $dane->fetch_assoc();
				        $idproj = $dane['id'];
                        if ($polaczenie->query("INSERT INTO DLiderzy VALUES ('$idproj', '$id')")){
                                
                                $dane = $polaczenie->query("SELECT imie, nazwisko, email  FROM `DUsers`  WHERE id='$id'" ); 
				                $dane = $dane->fetch_assoc();
				                $imie = $dane['imie'];
                                $nazwisko = $dane['nazwisko'];
                                $email = $dane['email'];
                            
                                $email_active = "email_stworzenie_projektu.html";
                                $messeage = file_get_contents($email_active);
                                $messeage = str_replace("[Imie]", $imie, $messeage);
                                $messeage = str_replace("[Nazwisko]", $nazwisko, $messeage);
                                $messeage = str_replace("[Nazwa]", $nazwa, $messeage);
                                $messeage = str_replace("[url]", "http://" . $_SERVER['HTTP_HOST'].'/Draft/Projekt/projekt.php?id='.$idproj, $messeage);

                                $naglowki = "From: admin@and-dab.cba.pl\n" .
                                            "Reply-To: admin@and-dab.cba.pl\n" .
                                            "Content-type: text/html; charset=utf-8\n";

                                if(mail($email, "Potwierdzenie stworzenia projektu", $messeage, $naglowki))
                                {
                                      
                                    header('Location: projekt.php?id='.$idproj);
                                }
                                else
                                {
                                    $_SESSION['e_error']="blad przy wysyłce maila";
                                }
                                
                            }
                        
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
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
	<title>Draft - Stwórz projekt</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

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
             <div id="projekt">
                  
                      <?php
                                if (isset($_SESSION['e_error']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_error'].'</div>';
                                    unset($_SESSION['e_error']);
                                }
                            ?><br />
                   <form action="" method="post">
                        
                            Nazwa:  <br />
                            <input type="text" value="<?php
                            if (isset($_SESSION['fr_nazwa']))
                            {
                                echo $_SESSION['fr_nazwa'];
                                unset($_SESSION['fr_nazwa']);
                            }
                            ?>" name="nazwa" /><br/>

                            <?php
                                if (isset($_SESSION['e_nazwa']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_nazwa'].'</div>';
                                    unset($_SESSION['e_nazwa']);
                                }
                            ?><br />
                     
                        
                            cel: <br /> <input type="text" placeholder="Opisz krótko cel" value="<?php
                            if (isset($_SESSION['fr_opisk']))
                            {
                                echo $_SESSION['fr_opisk'];
                                unset($_SESSION['fr_opisk']);
                            }
                            ?>" name="opisk" /><br />

                            <?php
                                if (isset($_SESSION['e_opisk']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_opisk'].'</div>';
                                    unset($_SESSION['e_opisk']);
                                }
                            ?>   <br /> 

                        
                         Długi opis: <br /><textarea name="opisd"  cols="30" rows="20">
                             <?php
                            if (isset($_SESSION['fr_opisd']))
                            {
                                echo $_SESSION['fr_opisd'];
                                unset($_SESSION['fr_opisd']);
                            }
                            ?>
                         </textarea>
                           <br/>
            
                            
                             Miejsce na linka: <br /> <input type="text"  value="<?php
                            if (isset($_SESSION['fr_link']))
                            {
                                echo $_SESSION['fr_link'];
                                unset($_SESSION['fr_link']);
                            }
                        ?>" name="link" /><br />

                        <?php
                            if (isset($_SESSION['e_link']))
                            {
                                echo '<div class="error">'.$_SESSION['e_link'].'</div>';
                                unset($_SESSION['e_link']);
                            }
                        ?> <br/>
                        
                          Benefity co morze zyskać projekt: <br /><textarea name="benefity"  cols="30" rows="20">
                             <?php
                            if (isset($_SESSION['fr_benefity']))
                            {
                                echo $_SESSION['fr_benefity'];
                                unset($_SESSION['fr_benefity']);
                            }
                            ?>
                         </textarea>
                           <br/>
                       <br/>
                       <div class="g-recaptcha " data-sitekey="6LftLzYUAAAAAAmwmG4zeRgapuSlJdo2Qidcf2qX"></div>

                        <?php
                            if (isset($_SESSION['e_bot']))
                            {
                                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                                unset($_SESSION['e_bot']);
                            }
                        ?>	

                        <br />

                        <input type="submit" value="Zarejestruj się" />

                    </form>    
                    
         </div>
    </div>
    </div>
	
	<script src="Draft/jquery"> </script>
	<script src="Draft/stickymenu"> </script>


</body>
</html>