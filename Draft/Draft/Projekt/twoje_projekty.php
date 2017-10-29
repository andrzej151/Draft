<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>    
Draft - twoje-projekty
</title>
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
                        <li><a href="profil">Profil</a></li>
                        <li><a href="../aktualnosci">Aktualności</a></li>
                        <li>Projekt
                            <ul>
                                <li><a href="../stworz-projekt">Stwórz</a></li>
                                <li><a href="../twoje-projekty">Twoje</a></li>
                                <li><a href="../wszystkie-projekty">Wszystkie</a></li>
                            </ul>
                        </li>
                        <li><a href="../twoje-zadania">Zadania</a></li>
                        <li><a href="../baza-wiedzy">Baza Wiedzy</a></li>
                        <li><a href="../transakcje">Transakcje</a></li>
                        <li><a href="../kontakt">Kontakt</a></li>
                        <li><a href="wyloguj-sie">Wyloguj sie</a></li>					
			        </ol>
                </nav>
            </div>
        
        <div class="content">
            <div class="pole">
            TO DO
twoje-projekty
         </div>
    </div>
    </div>
	
	<script src="../js/jquery.min.js"> </script>
	<script src="../js/stickymenu.js"> </script>


</body>
</html>
