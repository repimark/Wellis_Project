<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$nev = $conn->real_escape_string($_POST["uName"]);
		$jelszo = $conn->real_escape_string($_POST["uPass"]);
		$jog = $conn->real_escape_string($_POST["jogosultsag"]);
		//Létező felhasználó ellenőrzése
		$checkUserSQL = "SELECT `u_id` FROM `users` WHERE `u_name` = '".$nev."'";
		if($checkResult = $conn->query($checkUserSQL)){
			
			$numResult = mysqli_num_rows($checkResult);
			//echo $numResult;
			if($numResult > 0){
				echo "Ez a felhasználó már létezik !!";
			}else{
				$sql = "INSERT INTO `users` (`u_id`, `u_name`, `u_pass`, `u_jog`) VALUES (NULL, '".$nev."', MD5('".$jelszo."'), '$jog')";
				if ($conn->query($sql)) {
					echo 'Sikeres';
				}
			}
			mysqli_close($conn);
		}else{
			echo "Sikertelen a lekérdezés";
		}
		
	}

?>