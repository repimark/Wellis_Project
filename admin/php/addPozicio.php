<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$elnevezes = $conn->real_escape_string($_POST["elnev"]);
		$terulet = $conn->real_escape_string($_POST["t_id"]);
		$sql = "INSERT INTO `pozicio` (`p_id`, `p_elnevezes`, `t_id`) VALUES (NULL, '".$elnevezes."', '".$terulet."')";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>