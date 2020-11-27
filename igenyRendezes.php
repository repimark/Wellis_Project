<?php 
	include("connect.php");
	$p_id = $conn->real_escape_string($_POST["p_id"]);
	$igenySajat = $conn->real_escape_string($_POST["i_sajat"]);
	$db = 0;
	$getIgenySQL = "SELECT i_db FROM igeny WHERE p_id = ".$p_id.";";
	$igenyResult = $conn->query($getIgenySQL);
	while ($row = $igenyResult->fetch_assoc()) {
		$db = (int)$row["i_db"];
	}
	$newDarab = (int)$db - 1;
	$sql = "UPDATE `igeny` SET `i_db` = '".$newDarab."' WHERE `igeny`.`p_id` = ".$p_id." AND `igeny`.i_sajat = '".$igenySajat."'
	;";

	if ($conn->query($sql)) {
		echo "Sikerült";
	}else{
		echo $conn->error;
	}
	mysqli_close($conn);
 ?>