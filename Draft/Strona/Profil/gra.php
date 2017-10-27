<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Draft - Profil</title>
</head>

<body>
	
<?php

	echo "<p>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']." ".$_SESSION['punkty'].'pkt! [ <a href="../Rejestracja/logout.php">Wyloguj się!</a> ]</p>';
	
 
	
?>

</body>
</html>