<?php 
	include('connect.php');
	$db = $conn->real_escape_string($_POST["menny"]);
	$i_id = $conn->real_escape_string($_POST["i_id"]);
	$sql = "UPDATE `igeny` SET `i_db` = '".$db."' WHERE `igeny`.`i_id` = '".$i_id."'";
	if ($conn->query($sql)) {
		echo "Sikeres";
	}else{
		echo $db;
		echo $i_id;
		echo "Sikertelen";
	}
	mysqli_close($conn);
?>