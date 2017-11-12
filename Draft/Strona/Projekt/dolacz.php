<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/index');
		exit();
	}
	if (!isset($_GET['idproj']))
	{
		header('Location: Draft/index');
		exit();
	}

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
                $idp=$_GET['idproj'];
                $idu=$_SESSION['id'];
                $rezultat = $polaczenie->query("SELECT * FROM `DUczestnProj` WHERE `idproj`='$idp' AND idusera='$idu'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich = $rezultat->num_rows;
				if($ile_takich==0)
				{
					 $rezultat = $polaczenie->query("INSERT INTO `DUczestnProj`(`idproj`, `idusera`) VALUES('$idp','$idu')");
                    header('Location: projekt.php?id='.$idp);
				}
                else
                {
                    
                    header('Location: projekt.php?id='.$idp);
                    
                }
				
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

	
					
				
	
	
	
?>
