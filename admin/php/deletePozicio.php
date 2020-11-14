<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["p_id"];
		include '../../connect.php';
		$deleteIgeny = "DELETE FROM `igeny` WHERE p_id = '".$id."'";
		$sql = "DELETE FROM `pozicio` WHERE p_id = '".$id."'";
		if ($conn->query($deleteIgeny)) {
			if ($conn->query($sql)) {
				echo 'Sikeres';
			}else{
				echo $conn->error;
			}
		}else{
			echo $conn->error;
		}
		mysqli_close($conn);
	}

?>