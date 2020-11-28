<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$id = $conn->real_escape_string($_POST["a_id"]);
		$sql = "DELETE FROM `admin` WHERE a_id ='".$id."'";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>