<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" href="../gra/gra.css">
	<title>Draft - Aktywacja</title>
</head>

<body>
<?php
	if(isset($_GET['activate']))
		{
			$key = $_GET['activate'];
			require_once "../Admin/connect.php";
			mysqli_report(MYSQLI_REPORT_STRICT);
		
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				if ($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{

					$polaczenie->set_charset("utf8");	
					$rezultat = $polaczenie -> query('SELECT `kod` FROM `DUsers` WHERE `kod` = "' . $key . '"');
					$ilu_userow = $rezultat->num_rows;
					if($ilu_userow>0)
					{
						$keyn = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
						$polaczenie -> query('UPDATE `DUsers` SET `status` = "AKT", `kod` = "'.$keyn.'"  WHERE `kod`= "' . $key . '"');
						
                        echo('
                        Dziękujemy za rejestrację w serwisie i aktywacje!  Możesz już zalogować się na swoje konto!<br /><br />
                        <a href="../index.php">Zaloguj się na swoje konto!</a>
                        ');
						
						
					}
					else
					{
						echo('Błedny klucz </br><a href="../index.php">Strona główna!</a>');
					}
				}
		}
		
?>
	
	

</body>
</html>