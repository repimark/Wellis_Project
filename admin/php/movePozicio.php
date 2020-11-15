<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$pid = $_POST["p_id"];
		$tid = $_POST["t_id"];
		include '../../connect.php';
		$movePozicio = "UPDATE `pozicio` SET `t_id` = '".$tid."' WHERE `pozicio`.`p_id` = '".$pid."'";
		if ($conn->query($movePozicio)) {
			echo 'Sikeres';
		}else{
			echo $conn->error;
		}
		mysqli_close($conn);
	}

?>