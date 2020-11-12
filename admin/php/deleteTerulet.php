<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["t_id"];
		include '../../connect.php';
		$sql = "DELETE FROM `terulet` WHERE t_id = '".$id."'";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>