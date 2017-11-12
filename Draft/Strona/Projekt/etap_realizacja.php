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
                $idusera=$_SESSION['id'];
                
                    $sql="SELECT idproj FROM DLiderzy WHERE idproj=".$idp." AND idusera=".$idusera;
                    $rezultat = $polaczenie->query($sql);
                  
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich>0)
                    {
                        $sql="UPDATE `DProjekty` SET `status`='REALIZACJA' WHERE `id`=".$idp;
                       $rezultat = $polaczenie->query($sql);
                        echo($sql);
				
                        if (!$rezultat) throw new Exception($polaczenie->error);
                        
                        header('Location: projekt.php?idproj='.$idp);
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

	
					
				
	
	
	
?>
