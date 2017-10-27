<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: Profil/gra.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Draft - strona główna</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	    <nav>
	        
			<ol>
				<li><a href="#">Strona główna</a></li>
				<li><a href="#">O Projekcie</a></li>
                <li><a href="#">Projekty</a></li>
                <li><a href="#">Kontakt</a></li>					
			</ol>
		    
	    </nav>
	    
    <div id="container">
	    <main>
	        <div id="logowanie">
                <a href="Rejestracja/rejestracja.php">
                    <button>Rejestracja  załóż darmowe konto!</button>
                </a>
                
	            <form action="Rejestracja/zaloguj.php" method="post">
	                  <input type="text" name="login" placeholder="Login"/> 
		              <input type="password" name="haslo" placeholder="Hasło"/> 
		            <input type="submit" value="Zaloguj się" />
		            <a href="Rejestracja/przypomnij_haslo.php">Przypomnij hasło!</a>
	            </form>
                <?php
	               if(isset($_SESSION['blad']))	{
                       echo '<div class="blad">';
                       echo $_SESSION['blad'];
                       echo '</div>';
                   }
                ?>
	        </div>
	        
	   
	       
	    </main>
	</div>
	
	

	
<script src="js/jquery.min.js"></script>
<script src="js/stickymenu.js"></script>
</body>
</html>