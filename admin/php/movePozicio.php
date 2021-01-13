<?php
session_start();
if (!isset($_SESSION["a_id"])) {
	header("location:../index.php");
} else {
	$pid = $_POST["p_id"];
	$tid = $_POST["t_id"];
	include '../../connect.php';
	$moveDolgozok = "UPDATE `dolgozok` SET `t_id` = '" . $tid . "' WHERE `dolgozok`.`p_id` = '" . $pid . "'";
	$moveIgeny = "UPDATE `igeny` SET `t_id` = '" . $tid . "' WHERE `igeny`.`p_id` = '" . $pid . "'";
	$movePozicio = "UPDATE `pozicio` SET `t_id` = '" . $tid . "' WHERE `pozicio`.`p_id` = '" . $pid . "'";
	if ($conn->query($moveDolgozok)) {
		if ($conn->query($moveIgeny)) {
			if ($conn->query($movePozicio)) {
				echo 'Sikeres';
			} else {
				echo $conn->error;
			}
		} else {
			echo $conn->error;
		}
	} else {
		echo $conn->error;
	}
	mysqli_close($conn);
}
?>