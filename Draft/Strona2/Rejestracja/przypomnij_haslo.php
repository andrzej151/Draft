<?php
    session_start();
    require_once "../Domena/head.php"; // menu
	
	if (isset($_POST['email']))
	{
        // Sprawdź poprawność adresu email
        $wszystko_OK=true;
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        
        if (empty($email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
        if($wszystko_OK)
        {
            require_once "../Admin/database.php";
            
            //Czy email już istnieje?
            
            $query_email = $db->prepare("SELECT id FROM DUsers WHERE email= :email");
            $query_email->bindValue(':email', $email, PDO::PARAM_STR);
            $query_email->execute();
            
            if($query_email->rowCount()>0)
            {
                $kod = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
                
               
                $query_email = $db->prepare("UPDATE DUsers SET status = 'ZBL', kod = :kod  WHERE email= :email");
                $query_email->bindValue(':email', $email, PDO::PARAM_STR);
                $query_email->bindValue(':kod', $kod, PDO::PARAM_STR);
                $query_email->execute();
                
                $email_active = "email_przypomnij_haslo.html";
						$messeage = file_get_contents($email_active);
						$messeage = str_replace("[Imie]", $imie, $messeage);
						$messeage = str_replace("[Nazwisko]", $nazwisko, $messeage);
						$messeage = str_replace("[key]", $kod, $messeage);
						$messeage = str_replace("[url]", "http://" . $_SERVER['HTTP_HOST'].'/Draft/zmien-haslo', $messeage);

					$naglowki = "From: admin@andrzejd.cba.pl\n" .
							"Reply-To: admin@andrzejd.cba.pl\n" .
							"Content-type: text/html; charset=utf-8\n";

						if(mail($email, "Przypomnienie hasła", $messeage, $naglowki))
                        {
                            $_SESSION['succes']="Na maila wysłaliśmy link do zmiany hasła";
                        }
                        else
                        {
                            $_SESSION['e_email']="blad przy wysyłce maila";
                        }
                
					
            }else{
                $wszystko_OK=false;
					$_SESSION['e_email']="Błedny adres email.";
            }
        }
    }
        

?>



    <div class="content">
        <div class="pole">
            <?php
                        if (isset($_SESSION['succes']))
                        {
                            echo '<p class="succes">'.$_SESSION['succes'].'</p>';
                            unset($_SESSION['succes']);
                        }
                    ?>
                <h4>Przypomnij hasło</h4>
                <form action="" method="post">
                    <p>Podaj adres e-mail podany podczas rejestracji</p>
                    <label for="email">E-mail</label>
                    <input type="email" id="email" <?=isset($_SESSION[ 'fr_email'])? 'value="'.$_SESSION[ 'fr_email']. '"' : ''?> name="email" required/>
                    <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<p class="error">'.$_SESSION['e_email'].'</p>';
                                unset($_SESSION['e_email']);
                                unset($_SESSION['fr_email']);
                            }
                        ?>

                        <input type="submit" value="Wyslij link" />
                </form>
        </div>
    </div>
    </div>

    <script src="js/jquery.min.js">


    </script>
    <script src="js/stickymenu.js">


    </script>

    </body>

    </html>
