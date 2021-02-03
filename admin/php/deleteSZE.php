<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["szt_id"];
		include '../../connect.php';
		$sql = "DELETE FROM `szellemi_terulet` WHERE szt_id = '".$id."'";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>