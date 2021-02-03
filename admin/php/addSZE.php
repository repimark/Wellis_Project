<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$elnevezes = $conn->real_escape_string($_POST["elnev"]);
		$sql = "INSERT INTO `szellemi_terulet` (`szt_id`, `szt_elnevezes`) VALUES (NULL, '".$elnevezes."')";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>