<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: Draft/profil');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Draft - strona główna</title>
	<link rel="stylesheet" href="Draft/style">
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
                        <li><a href="../Draft/index">Strona główna</a></li>
                        <li><a href="#">O Projekcie</a></li>
                        <li><a href="#">Projekty</a></li>
                        <li><a href="#">Kontakt</a></li>					
			        </ol>
                </nav>
            </div>
        
        <div class="content">
             <main>
                <div id="logowanie">
                    <a href="../Draft/rejestracja">
                        <button>Rejestracja  załóż darmowe konto!</button>
                    </a>

                    <form action="../Draft/Rejestracja/zaloguj.php" method="post">
                          <input type="text" name="login" placeholder="Login"/> 
                          <input type="password" name="haslo" placeholder="Hasło"/> 
                        <input type="submit" value="Zaloguj się" />
                        <a href="../Draft/przypomnij-haslo">Przypomnij hasło!</a>
                    </form>
                    <?php
                       if(isset($_SESSION['blad']))	{
                           echo '<div class="blad">';
                           echo $_SESSION['blad'];
                           echo '</div>';
                           unset($_SESSION['blad']);
                       }
                    ?>
                </div>
	    </main>
        </div>
        
    </div>
	

	
<script src="Draft/jquery"></script>
<script src="Draft/stickymenu"></script>
</body>
</html>