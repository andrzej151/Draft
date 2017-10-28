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
                        <li><a href="#">Profil</a></li>
                        <li><a href="#">Aktualności</a></li>
                        <li><a href="#">Projekt</a>
                            <ul>
                                <li><a href="">Stwórz</a></li>
                                <li><a href="">Twoje</a></li>
                                <li><a href="">Wszystkie</a></li>
                            </ul>
                        </li>
                        <li><a href="">Zadania</a></li>
                        <li><a href="">Baza Wiedzy</a></li>
                        <li><a href="">Transakcje</a></li>
                        <li><a href="#">Kontakt</a></li>					
			        </ol>
                </nav>
            </div>
        
        <div class="content">
            <div class="pole">
            <?php

	echo "<p>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']." ".$_SESSION['punkty'].'pkt! [ <a href="../Rejestracja/logout.php"><button class="btn-dgr">Wyloguj się!</button></a> ]</p>';
	
 
	
?>
            </div>
         </div>
    </div>
	
	<script src="../js/jquery.min.js"> </script>
	<script src="../js/stickymenu.js"> </script>


</body>
</html>