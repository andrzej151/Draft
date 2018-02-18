<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: Draft/profil');
		exit();
	}

define("ROOT_PATH",  dirname(__FILE__));

require_once( ROOT_PATH . "/Domena/head.php");
?>        
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