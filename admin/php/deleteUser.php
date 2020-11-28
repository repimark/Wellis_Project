<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$id = $conn->real_escape_string($_POST["u_id"]);
		$sql = "DELETE FROM `users` WHERE u_id ='".$id."'";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>