<?php
    session_start();
	
	if (isset($_GET['key']))
	{
        if (isset($_POST['haslo1']))
	   {
       //Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
        $kod = $_GET['key'];
		
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
                    $rezultat = $polaczenie->query("SELECT id FROM DUsers WHERE kod='$kod'");

                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich_kodow = $rezultat->num_rows;
                    if($ile_takich_kodow>0)
                    {
                         $key = password_hash(rand(123, 12345), PASSWORD_DEFAULT);

                        //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

                        if ($polaczenie->query('UPDATE `DUsers` SET `haslo` = "'. $haslo_hash .'", `kod` = "'.$key.'"  WHERE `kod`="' . $kod .'"' ))
                        {
                            header('Location: zmiana.php');
                        }
                        else
                        {
                            $_SESSION['e_haslo'] = 'UPDATE `DUsers` SET `haslo` = "'. $haslo_hash .'", `kod` = "'.$key.'"  WHERE `kod`="' . $kod .'"' ;
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
        
    }


?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" href="../gra/gra.css">
	<title>Draft - Przypomnij haslo</title>
</head>

<body>
  <?php
			if (isset($_SESSION['succes']))
			{
				echo '<div >'.$_SESSION['succes'].'</div>';
				unset($_SESSION['e_succes']);
			}
		?>
   <p>Zmień hasło</p>
    <form action="" method="post">
        	Twoje hasło: <br /> <input type="password"  name="haslo1" /><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		
		Powtórz hasło: <br /> <input type="password"  name="haslo2" /><br />
   
   <input type="submit" value="Wyslij link" />
    </form>
</body>
</html>
