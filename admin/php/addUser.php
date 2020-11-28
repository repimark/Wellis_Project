<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$nev = $conn->real_escape_string($_POST["uName"]);
		$jelszo = $conn->real_escape_string($_POST["uPass"]);
		$sql = "INSERT INTO `users` (`u_id`, `u_name`, `u_pass`, `u_jog`) VALUES (NULL, '".$nev."', MD5('".$jelszo."'), '1')";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>