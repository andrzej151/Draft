<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/index');
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
            <div class="pole">
            <?php
                echo "<p>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']." ".$_SESSION['punkty'].'pkt! </p>';   
	           ?>
	     
         </div>
    </div>
    </div>
	
	<script src="../js/jquery.min.js"> </script>
	<script src="../js/stickymenu.js"> </script>


</body>
</html>