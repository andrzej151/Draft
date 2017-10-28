<?php
    session_start();
	
	if (isset($_POST['email']))
	{
    // Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
        
        
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
				     $kod = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
                    
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
                    
					if ($polaczenie->query('UPDATE `DUsers` SET `status` = "AKT", `kod` = "'.$kod.'"  WHERE `email`= "' . $email . '"'))
					{
                        $email_active = "email_przypomnij_haslo.html";
						$messeage = file_get_contents($email_active);
						$messeage = str_replace("[Imie]", $imie, $messeage);
						$messeage = str_replace("[Nazwisko]", $nazwisko, $messeage);
						$messeage = str_replace("[key]", $kod, $messeage);
						$messeage = str_replace("[url]", "http://" . $_SERVER['HTTP_HOST'].'/Draft/rejestracja/zmian_haslo.php', $messeage);

						$naglowki = "From: admin@and-dab.cba.pl\n" .
									"Reply-To: admin@and-dab.cba.pl\n" .
									"Content-type: text/html; charset=utf-8\n";

						if(mail($email, "Przypomnienie hasła", $messeage, $naglowki))
                        {
                            $_SESSION['succes']="Na maila wysłaliśmy link do zmiany hasła";
                        }
                        else
                        {
                            echo("blad przy wysyłce maila");
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
	<link rel="stylesheet" type="text/css" href="../gra/gra.css">
	<title>Draft - Przypomnij haslo</title>
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
                        <li><a href="#">Strona główna</a></li>
                        <li><a href="#">O Projekcie</a></li>
                        <li><a href="#">Projekty</a></li>
                        <li><a href="#">Kontakt</a></li>					
			        </ol>
                </nav>
            </div>
        
        <div class="content">
            <div class="pole">
                  <?php
                        if (isset($_SESSION['succes']))
                        {
                            echo '<div >'.$_SESSION['succes'].'</div>';
                            unset($_SESSION['succes']);
                        }
                    ?>
               <p>Przypomnij hasło</p>
                <form action="" method="post">
                        Podaj E-mail podany przy rejestracji: <br /> <input type="text"  name="email" /><br />

                    <?php
                        if (isset($_SESSION['e_email']))
                        {
                            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                    ?>

               <input type="submit" value="Wyslij link" />
                </form>
            </div>
         </div>
    </div>
	
	<script src="../js/jquery.min.js"> </script>
	<script src="../js/stickymenu.js"> </script>

</body>
</html>
