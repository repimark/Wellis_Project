<?php 
	include("connect.php");
	$id = $conn->real_escape_string($_POST["m_id"]);
	$szoveg = $conn->real_escape_string($_POST["m_text"]);
	$sql = "UPDATE `megjegyzes` SET `m_szoveg` = '".$szoveg."' WHERE `megjegyzes`.`m_id` = ".$id."";
	if ($conn->query($sql)) {
		echo "Sikerült";
	}else{
		echo $conn->error;
	}
	mysqli_close($conn);
?>