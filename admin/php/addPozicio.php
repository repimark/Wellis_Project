<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$elnevezes = $_POST["elnev"];
		$terulet = $_POST["t_id"];
		include '../../connect.php';
		$sql = "INSERT INTO `pozicio` (`p_id`, `p_elnevezes`, `t_id`) VALUES (NULL, '".$elnevezes."', '".$terulet."')";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>