<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$pid = $_POST["p_id"];
		$elnevezes = $_POST["p_elnevezes"];
		include '../../connect.php';
		
		$movePozicio = "UPDATE `pozicio` SET `p_elnevezes` = '".$elnevezes."' WHERE `pozicio`.`p_id` = '".$pid."'";
		if ($conn->query($movePozicio)) {
			echo 'Sikeres';
		}else{
			echo $conn->error;
		}
		mysqli_close($conn);
	}

?>