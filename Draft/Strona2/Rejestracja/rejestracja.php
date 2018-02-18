<?php
	session_start();
    require_once "../Domena/head.php"; // menu

	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$login = filter_input(INPUT_POST, 'login');
        
        //Sprawdź poprawność imienia
		$imie = filter_input(INPUT_POST, 'imie');
        
        //Sprawdź poprawność nazwiska
		$nazwisko = filter_input(INPUT_POST, 'nazwisko');
		
		//Sprawdzenie długości nicka
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
		}
        
        //Sprawdzenie długości imienia
		if ((strlen($imie)<3) || (strlen($imie)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imię musi posiadać od 3 do 20 znaków!";
		}
        
        //Sprawdzenie długości nazwiska
		if ((strlen($nazwisko)<3) || (strlen($nazwisko)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		
		if (empty($email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = filter_input(INPUT_POST, 'password');
		$haslo2 = filter_input(INPUT_POST, 'password2');
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_password2']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		//Bot or not? Oto jest pytanie!
		$sekret = "6LcmlEYUAAAAAJQIr2bbSE2PaqexJ_sk4t7HB3n_";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
        if(!$wszystko_OK){
            //Zapamiętaj wprowadzone dane
            $_SESSION['fr_login'] = $_POST['login'];
            $_SESSION['fr_imie'] = $_POST['imie'];
            $_SESSION['fr_nazwisko'] = $_POST['nazwisko'];
            $_SESSION['fr_email'] = $_POST['email'];
            $_SESSION['fr_password'] = $_POST['password'];
            $_SESSION['fr_password2'] = $_POST['password2'];
            if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
        }else{
            
            require_once "../Admin/database.php";
            
            //Czy email już istnieje?
            
            $query_email = $db->prepare("SELECT id FROM DUsers WHERE email= :email");
            $query_email->bindValue(':email', $email, PDO::PARAM_STR);
            $query_email->execute();
            
            if($query_email->rowCount()>0)
            {
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
            }
            
            //Czy nick jest już zarezerwowany?
            
            $query = $db->prepare("SELECT id FROM DUsers WHERE login= :login");
    
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->execute();
            
           
            
            if($query->rowCount()>0)
            {
					$wszystko_OK=false;
					$_SESSION['e_login']="Istnieje już gracz o takim loginie! Wybierz inny.";
            }
            
            if ($wszystko_OK)
            {
                $kod = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
                    
				//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
                 $query = $db->prepare("INSERT INTO DUsers VALUES (NULL, :login, :haslo, :kod, 'ZAL', :imie, :nazwisko, :email, 50)");
                $query->bindValue(':login', $login, PDO::PARAM_STR);
                $query->bindValue(':haslo', $haslo_hash, PDO::PARAM_STR);
                $query->bindValue(':kod', $kod, PDO::PARAM_STR);
                $query->bindValue(':imie', $imie, PDO::PARAM_STR);
                $query->bindValue(':nazwisko', $nazwisko, PDO::PARAM_STR);
                $query->bindValue(':email', $email, PDO::PARAM_STR);
                $query->execute();
                
                $email_active = "email_aktywacja.html";
				$messeage = file_get_contents($email_active);
				$messeage = str_replace("[Imie]", $imie, $messeage);
				$messeage = str_replace("[Nazwisko]", $nazwisko, $messeage);
				$messeage = str_replace("[key]", $kod, $messeage);
				$messeage = str_replace("[url]", "http://".$_SERVER['HTTP_HOST'].'/Draft/aktywacja', $messeage);

				$naglowki = "From: admin@andrzejd.cba.pl\n" .
							"Reply-To: admin@andrzejd.cba.pl\n" .
							"Content-type: text/html; charset=utf-8\n";

				if(mail($email, "Potwierdzenie maila", $messeage, $naglowki))
                {
                    $_SESSION['udanarejestracja']=true;
                    unset($_SESSION['fr_login']); 
                    unset($_SESSION['fr_imie']);
                    unset($_SESSION['fr_nazwisko']); 
                    unset($_SESSION['fr_email']); 
                    unset($_SESSION['fr_password']);
                    unset($_SESSION['fr_password2']);    
                    unset($_SESSION['fr_regulamin']);
                    unset($_SESSION['e_login']); 
                    unset($_SESSION['e_imie']);
                    unset($_SESSION['e_nazwisko']); 
                    unset($_SESSION['e_email']); 
                    unset($_SESSION['e_password']);
                    unset($_SESSION['e_password2']);    
                    unset($_SESSION['e_regulamin']);      
				    header('Location: witamy.php');
                    exit();
                }
                    
                
            }else
            {
                //Zapamiętaj wprowadzone dane
                $_SESSION['fr_login'] = $_POST['login'];
                $_SESSION['fr_imie'] = $_POST['imie'];
                $_SESSION['fr_nazwisko'] = $_POST['nazwisko'];
                $_SESSION['fr_email'] = $_POST['email'];
                $_SESSION['fr_password'] = $_POST['password'];
                $_SESSION['fr_password2'] = $_POST['password2'];
                if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
            }
        }
    }
        
   
?>

        <div class="content">
                <div id="rejestracja">
                   <form action="" method="post">

                        <label for="login">Login</label> 
                        <input type="text" id="login"
                        <?= isset($_SESSION['fr_login'])?'value="'.$_SESSION['fr_login'].'"' :''?>  name="login" required />
                        <?php
                            if (isset($_SESSION['e_login']))
                            {
                                echo '<p class="error">'.$_SESSION['e_login'].'</p>';
                                unset($_SESSION['e_login']);
                                unset($_SESSION['fr_login']);
                            }
                        ?>
                        
                        <label for="imie">Imię</label> 
                        <input type="text" id="imie"
                        <?= isset($_SESSION['fr_imie'])?'value="'.$_SESSION['fr_imie'].'"' :''?>  name="imie" required/>
                        <?php
                            if (isset($_SESSION['e_imie']))
                            {
                                echo '<p class="error">'.$_SESSION['e_imie'].'</p>';
                                unset($_SESSION['e_imie']);
                                unset($_SESSION['fr_imie']);
                            }
                        ?>
                        
                        <label for="nazwisko">Nazwisko</label> 
                        <input type="text"  id="nazwisko"
                        <?= isset($_SESSION['fr_nazwisko'])?'value="'.$_SESSION['fr_nazwisko'].'"' :''?>  name="nazwisko" required/>
                        <?php
                            if (isset($_SESSION['e_nazwisko']))
                            {
                                echo '<p class="error">'.$_SESSION['e_nazwisko'].'</p>';
                                unset($_SESSION['e_nazwisko']);
                                unset($_SESSION['fr_nazwisko']);
                            }
                        ?>
                        
                        <label for="email">E-mail</label> 
                        <input type="email" id="email"
                        <?= isset($_SESSION['fr_email'])?'value="'.$_SESSION['fr_email'].'"' :''?>  name="email" required/>
                        <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<p class="error">'.$_SESSION['e_email'].'</p>';
                                unset($_SESSION['e_email']);
                                unset($_SESSION['fr_email']);
                            }
                        ?>
                        
                        <label for="password">Hasło</label> 
                        <input type="password" id="password"
                        <?= isset($_SESSION['fr_password'])?'value="'.$_SESSION['fr_password'].'"' :''?>  name="password" required/>
                        <?php
                            if (isset($_SESSION['e_password']))
                            {
                                echo '<p class="error">'.$_SESSION['e_password'].'</p>';
                                unset($_SESSION['e_password']);
                                unset($_SESSION['fr_password']);
                            }
                        ?>
                        
                        <label for="password2">Powtórz hasło</label> 
                        <input type="password" id="password2"
                        <?= isset($_SESSION['fr_password2'])?'value="'.$_SESSION['fr_password2'].'"' :''?>  name="password2" required/>
                        <?php
                            if (isset($_SESSION['e_password2']))
                            {
                                echo '<p class="error">'.$_SESSION['e_password2'].'</p>';
                                unset($_SESSION['e_password2']);
                                unset($_SESSION['fr_password2']);
                            }
                        ?>
                        
                        <label for="regulamin">Akceptuje regulamin</label> 
                        <input type="checkbox" id="regulamin"
                        <?= isset($_SESSION['fr_regulamin'])?'checked' :''?>  name="regulamin" required/>
                       
                        <?php
                            if (isset($_SESSION['e_regulamin']))
                            {
                                echo '<p class="error">'.$_SESSION['e_regulamin'].'</p>';
                                unset($_SESSION['e_regulamin']);
                                unset($_SESSION['fr_regulamin']);
                            }
                        ?>
                        
                         <div class="g-recaptcha" data-sitekey="6LcmlEYUAAAAAMj1GgZnEwzFSGhgEK0cJgRkHYJd"></div>

                        <?php
                            if (isset($_SESSION['e_bot']))
                            {
                                echo '<p class="error">'.$_SESSION['e_bot'].'</p>';
                                unset($_SESSION['e_bot']);
                            }
                        ?>	


                        <input type="submit" value="Zarejestruj się" />

                    </form>    
                    
         </div>
    </div>
</div>

	
	<script src='https://www.google.com/recaptcha/api.js'></script>    
	<script src="Draft/jquery"></script>
    <script src="Draft/stickymenu"></script>

</body>
</html>