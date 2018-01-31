<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/index');
		exit();
	}
	if (!isset($_GET['idzad']))
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
                $idzad=$_GET['idzad'];
                $idusera=$_SESSION['id'];
                
                    $sql="SELECT * FROM DUczestnProj, DZadanieG WHERE DUczestnProj.idproj=DZadanieG.idproj AND DUczestnProj.idusera=".$idusera." AND DZadanieG.id=".$idzad;
                     
            
                    $rezultat = $polaczenie->query($sql);
                
                while($row=mysqli_fetch_assoc($rezultat)){ 
				        $zadanie[]=$row; 
                    
                    }
              
            
                $idproj=$zadanie[0]["idproj"];
                  
				
                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich = $rezultat->num_rows;
                    if($ile_takich>0)
                    {
                        $sql="INSERT INTO `DZadDoProj`(`id`, `idProj`, `idZadG`, `idUsera`, `status`, `punkty`) VALUES (NULL ,'$idproj','$idzad','$idusera','PRZYJETO', 5)";
                        
                        //echo($sql);
                       $rezultat = $polaczenie->query($sql);
                        
				
                        if (!$rezultat) throw new Exception($polaczenie->error);
                        
                        $sql="UPDATE `DZadanieG` SET `status`='REALIZACJA' WHERE id=".$idzad;
                        echo($sql);
                        
                        $rezultat = $polaczenie->query($sql);
                        
				
                        if (!$rezultat) throw new Exception($polaczenie->error);
                        
                        header('Location: zadanie.php?idzad='.$idzad);
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
