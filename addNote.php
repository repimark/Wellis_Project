<?php 
	$id = $_POST["m_id"];
	$szoveg = $_POST["m_text"];
	include("connect.php");
	$sql = "UPDATE `megjegyzes` SET `m_szoveg` = '".$szoveg."' WHERE `megjegyzes`.`m_id` = ".$id."";
	if ($conn->query($sql)) {
		echo "Sikerült";
	}else{
		echo "Sikertelen";
	}
	mysqli_close($conn);
?>