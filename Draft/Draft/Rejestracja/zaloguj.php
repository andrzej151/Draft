<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index');
		exit();
	}

	require_once "../Admin/connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM DUsers WHERE login='%s' AND status='AKT'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['haslo']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['punkty'] = $wiersz['punkty'];
				
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: ../profil');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login hasło lub konto nie aktywne!</span>';
					header('Location: ../index');
				}
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login hasło lub konto nie aktywne</span>';
				header('Location: ../index');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>