<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$elnevezes = $conn->real_escape_string($_POST["elnev"]);
		$sql = "INSERT INTO `terulet` (`t_id`, `t_elnevezes`) VALUES (NULL, '".$elnevezes."')";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>