<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
        
        //Sprawdź poprawność imienia
		$imie = $_POST['imie'];
        
        //Sprawdź poprawność nazwiska
		$nazwisko = $_POST['nazwisko'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
        
        //Sprawdzenie długości imienia
		if ((strlen($imie)<3) || (strlen($imie)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imię musi posiadać od 3 do 20 znaków!";
		}
        
        //Sprawdzenie długości nazwiska
		if ((strlen($nazwisko)<3) || (strlen($nazwisko)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
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
		$_SESSION['fr_nick'] = $nick;
        $_SESSION['fr_imie'] = $imie;
        $_SESSION['fr_nazwisko'] = $nazwisko;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
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
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM DUsers WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM DUsers WHERE login='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
                    $kod = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
                    
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
                    
					if ($polaczenie->query("INSERT INTO DUsers VALUES (NULL, '$nick', '$haslo_hash', '$kod','ZAL', '$imie', '$nazwisko', '$email', 50)"))
					{
                        $email_active = "email_aktywacja.html";
						$messeage = file_get_contents($email_active);
						$messeage = str_replace("[Imie]", $imie, $messeage);
						$messeage = str_replace("[Nazwisko]", $nazwisko, $messeage);
						$messeage = str_replace("[key]", $kod, $messeage);
						$messeage = str_replace("[url]", "http://" . $_SERVER['HTTP_HOST'].'/Draft/aktywacja', $messeage);

						$naglowki = "From: admin@and-dab.cba.pl\n" .
									"Reply-To: admin@and-dab.cba.pl\n" .
									"Content-type: text/html; charset=utf-8\n";

						if(mail($email, "Potwierdzenie maila", $messeage, $naglowki))
                        {
                            $_SESSION['udanarejestracja']=true;
						      header('Location: witamy');
                        }
                        else
                        {
                            echo("blad przy wysyłce maila");
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
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Draft - załóż darmowe konto!</title>
	<link rel="stylesheet" href="css/style.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
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
                        <li><a href="#">Strona główna</a></li>
                        <li><a href="#">O Projekcie</a></li>
                        <li><a href="#">Projekty</a></li>
                        <li><a href="#">Kontakt</a></li>					
			        </ol>
                </nav>
            </div>
        
        <div class="content">
                <div id="rejestracja">
                   <form action="rejestracja" method="post">

                        Login: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_nick']))
                            {
                                echo $_SESSION['fr_nick'];
                                unset($_SESSION['fr_nick']);
                            }
                        ?>" name="nick" /><br />

                        <?php
                            if (isset($_SESSION['e_nick']))
                            {
                                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                                unset($_SESSION['e_nick']);
                            }
                        ?>

                            Imię: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_imie']))
                            {
                                echo $_SESSION['fr_imie'];
                                unset($_SESSION['fr_imie']);
                            }
                        ?>" name="imie" /><br />

                        <?php
                            if (isset($_SESSION['e_imie']))
                            {
                                echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                                unset($_SESSION['e_imie']);
                            }
                        ?>

                            Nazwisko: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_nazwisko']))
                            {
                                echo $_SESSION['fr_nazwisko'];
                                unset($_SESSION['fr_nazwisko']);
                            }
                        ?>" name="nazwisko" /><br />

                        <?php
                            if (isset($_SESSION['e_nazwisko']))
                            {
                                echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                                unset($_SESSION['e_nazwisko']);
                            }
                        ?>

                        E-mail: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_email']))
                            {
                                echo $_SESSION['fr_email'];
                                unset($_SESSION['fr_email']);
                            }
                        ?>" name="email" /><br />

                        <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                unset($_SESSION['e_email']);
                            }
                        ?>

                        Twoje hasło: <br /> <input type="password"  value="<?php
                            if (isset($_SESSION['fr_haslo1']))
                            {
                                echo $_SESSION['fr_haslo1'];
                                unset($_SESSION['fr_haslo1']);
                            }
                        ?>" name="haslo1" /><br />

                        <?php
                            if (isset($_SESSION['e_haslo']))
                            {
                                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                                unset($_SESSION['e_haslo']);
                            }
                        ?>		

                        Powtórz hasło: <br /> <input type="password" value="<?php
                            if (isset($_SESSION['fr_haslo2']))
                            {
                                echo $_SESSION['fr_haslo2'];
                                unset($_SESSION['fr_haslo2']);
                            }
                        ?>" name="haslo2" /><br />

                        <label>
                            <input type="checkbox" name="regulamin" <?php
                            if (isset($_SESSION['fr_regulamin']))
                            {
                                echo "checked";
                                unset($_SESSION['fr_regulamin']);
                            }
                                ?>/> Akceptuję regulamin
                        </label>

                        <?php
                            if (isset($_SESSION['e_regulamin']))
                            {
                                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                                unset($_SESSION['e_regulamin']);
                            }
                        ?>	

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
	
	    
	<script src="js/jquery.min.js"></script>
    <script src="js/stickymenu.js"></script>

</body>
</html>