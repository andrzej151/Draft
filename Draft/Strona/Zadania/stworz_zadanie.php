<?php

	session_start();

    	if (!isset($_GET['idproj']))
	{
		header('Location: ../Projekt/wszystkie_projekty.php');
		exit();
	}
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/');
		exit();
	}else{
        //zalogowany
        require_once "../Admin/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
            //statusy
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                
                    $idusera=$_SESSION['id'];
                    $idprojektu= $_GET['idproj'];
                  
        
                
                    $sql= "SELECT idproj FROM DLiderzy WHERE idproj=".$idprojektu." AND idusera=".$idusera;
                    $rezultat = $polaczenie->query($sql);
                    
          
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich==0)
                    {
                             header('Location: ../Projekt/projekt.php?idproj='.$idprojektu);
		                      exit();  
                                    
                    }
                    
				
                }
                
				
				
				$polaczenie->close();
			
        }
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
    }
        




	
	if (isset($_POST['nazwa']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nazwy
		$nazwa = $_POST['nazwa'];
        
		//Sprawdzenie długości nazwy
		if ((strlen($nazwa)<3) || (strlen($nazwa)>220))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwa']="nazwa musi posiadać od 3 do 220 znaków!";
		}
        
    
		$opis = $_POST['opis'];
        $maxosob =$_POST['maxosob'];
        $dedline =$_POST['dedline'];
        
         $priorytet =$_POST['priorytet'];
        
        if ($priorytet<1||$priorytet>9)
		{
			$wszystko_OK=false;
			$_SESSION['e_priorytet']="Priorytet musi byc liczba z przedzału [1 9]!";
		}
          if ($maxosob<1)
		{
			$wszystko_OK=false;
			$_SESSION['e_maxosob']="Max liczba musi byc liczbą wieksza niż 0!";
		}
        
        $punkty =$_POST['punkty'];
        $idprojektu = $_GET['idproj'];
        
     
		//Bot or not? Oto jest pytanie!
		$sekret = "6LftLzYUAAAAACVllnwQoqMjIATU09zEoVr7BydL";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nazwa'] = $nazwa;
        $_SESSION['fr_opis'] = $opis;
        $_SESSION['fr_dedline'] = $dedline;
		$_SESSION['fr_priorytet'] = $priorytet;
		$_SESSION['fr_punkty'] = $punkty;
        $_SESSION['fr_maxosob'] = $maxosob;
	
		require_once "../Admin/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
               
				
				if ($wszystko_OK==true)
				{
                    
                    
					if ($polaczenie->query("INSERT INTO `DZadanieG`(`id`, `idproj`, `nazwa`, `opis`, `punkty`, `priorytet`, `dedline`, `status`, ileosob,`link`) VALUES (NULL,'$idprojektu','$nazwa','$opis','$punkty','$priorytet','$dedline','DODANO', '$maxosob',NULL)"))
					{
                        
                        $_SESSION['succes']="Zadanie dodano poprawnie"; 
                        
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Draft - Stwórz projekt</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
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
            
             <div id="projekt">
                  <?php
                        if (isset($_SESSION['succes']))
                                {
                                    echo '<div class="succes">'.$_SESSION['succes'].'</div>';
                                    unset($_SESSION['succes']);
                                }
                  
                      
                                if (isset($_SESSION['e_error']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_error'].'</div>';
                                    unset($_SESSION['e_error']);
                                }
                            ?><br />
                   <form action="" method="post">
                        
                            Nazwa:  <br />
                            <input type="text" value="<?php
                            if (isset($_SESSION['fr_nazwa']))
                            {
                                echo $_SESSION['fr_nazwa'];
                                unset($_SESSION['fr_nazwa']);
                            }
                            ?>" name="nazwa" /><br/>

                            <?php
                                if (isset($_SESSION['e_nazwa']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_nazwa'].'</div>';
                                    unset($_SESSION['e_nazwa']);
                                }
                            ?><br />
                            
                              Opis: <br /><textarea name="opis"  cols="30" rows="20">
                             <?php
                            if (isset($_SESSION['fr_opis']))
                            {
                                echo $_SESSION['fr_opis'];
                                unset($_SESSION['fr_opis']);
                            }
                            ?>
                         </textarea>
                           <br/>
                     
                        
                            dedline: <br /> <input type="date"  value="<?php
                            if (isset($_SESSION['fr_dedline']))
                            {
                                echo $_SESSION['fr_dedline'];
                                unset($_SESSION['fr_dedline']);
                            }
                            ?>" name="dedline" /><br />

                            <?php
                                if (isset($_SESSION['e_dedline']))
                                {
                                    echo '<div class="e_dedline">'.$_SESSION['e_dedline'].'</div>';
                                    unset($_SESSION['e_dedline']);
                                }
                            ?>   <br /> 

                        
                          Priorytet: <br /> <input type="number"  value="<?php
                            if (isset($_SESSION['fr_priorytet']))
                            {
                                echo $_SESSION['fr_priorytet'];
                                unset($_SESSION['fr_priorytet']);
                            }
                        ?>" name="priorytet" /><br />

                        <?php
                            if (isset($_SESSION['e_priorytet']))
                            {
                                echo '<div class="error">'.$_SESSION['e_priorytet'].'</div>';
                                unset($_SESSION['e_priorytet']);
                            }
                        ?> <br/>
                           
                           Max liczba osób: <br /> <input type="number"  value="<?php
                            if (isset($_SESSION['fr_maxosob']))
                            {
                                echo $_SESSION['fr_maxosob'];
                                unset($_SESSION['fr_maxosob']);
                            }
                        ?>" name="maxosob" /><br />

                        <?php
                            if (isset($_SESSION['e_maxosob']))
                            {
                                echo '<div class="error">'.$_SESSION['e_maxosob'].'</div>';
                                unset($_SESSION['e_maxosob']);
                            }
                        ?> <br/>
                            
                             Punkty: <br /> <input type="number"  value="<?php
                            if (isset($_SESSION['fr_punkty']))
                            {
                                echo $_SESSION['fr_punkty'];
                                unset($_SESSION['fr_punkty']);
                            }
                        ?>" name="punkty" /><br />

                        <?php
                            if (isset($_SESSION['e_punkty']))
                            {
                                echo '<div class="error">'.$_SESSION['e_punkty'].'</div>';
                                unset($_SESSION['e_punkty']);
                            }
                        ?> <br/>
                        
                          
                       <div class="g-recaptcha " data-sitekey="6LftLzYUAAAAAAmwmG4zeRgapuSlJdo2Qidcf2qX"></div>

                        <?php
                            if (isset($_SESSION['e_bot']))
                            {
                                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                                unset($_SESSION['e_bot']);
                            }
                        ?>	

                        <br />

                        <input type="submit" value="Dodaj zadanie" />

                    </form>    
                    
         </div>
    </div>
    </div>
	
	<script src="Draft/jquery"> </script>
	<script src="Draft/stickymenu"> </script>


</body>
</html>