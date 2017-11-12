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
                
               
                $rez = $polaczenie->query("SELECT * FROM `DLiderzy` WHERE `idusera`='$idu' AND `idproj`='$idp'");
				
                if (!$rez) throw new Exception($polaczenie->error);
				
                $lider = $rez->num_rows;
                
				if($lider==1)
				{
                     $rezultat = $polaczenie->query("SELECT * FROM `DLiderzy` WHERE `idproj`='$idp' ");
                    
                    if (!$rezultat) throw new Exception($polaczenie->error);
				    $ilu_liderow = $rezultat->num_rows;
                    
                    if($ilu_liderow>1)
                    {
                         $rezultat = $polaczenie->query("DELETE FROM `DLiderzy` WHERE `idusera`='$idu' AND `idproj`='$idp'");	
                        $rezultat = $polaczenie->query("DELETE FROM `DUczestnProj` WHERE `idusera`='$idu' AND `idproj`='$idp'");	
                        header('Location: projekt.php?id='.$idp);
                    }
                    else
                    {
                        header('Location: dodaj_lidera.php?idproj='.$idp);
                    }
                }
                else
                {
                   
                             $rezultat = $polaczenie->query("DELETE FROM `DUczestnProj` WHERE `idusera`='$idu' AND `idproj`='$idp'");	
                            header('Location: projekt.php?id='.$idp);
                  
                    }
                }
               
                    
        
				
				
				$polaczenie->close();
			}
			
		
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

	
					
				
	
	
	
?>
