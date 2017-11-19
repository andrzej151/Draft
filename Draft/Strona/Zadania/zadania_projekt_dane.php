<?php
/*	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Draft/');
		exit();
	}*/

		require_once "../Admin/connect.php";
		
	mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{

			mysql_connect($host,$db_user,$db_password); 
			mysql_select_db($db_name); 
			//$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			//$polaczenie->set_charset("utf8");
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
                $idproj = $_GET['idproj'];
                $q ='SELECT id, nazwa, punkty, priorytet, dedline, status, ileosob
FROM `DZadanieG` WHERE `idproj`='.$idproj;
            
                $sql=mysql_query($q);
                while($row=mysql_fetch_assoc($sql)){ 
				$output[]=$row; 
				} 
				$dane=json_encode($output);
				echo($dane); 
                        	
				}
				

			}
			
		
		catch(Exception $e)
		{
			
		}
