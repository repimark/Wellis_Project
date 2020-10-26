<?php 
	include("connect.php");
	$id = $_POST["d_id"];
	$nev = $_POST["nev"];
	$p_id = $_POST["p_id"];
	$t_id = $_POST["t_id"];
	$a_id = $_POST["a_id"];
	$datum = $_POST["datum"];

	$sqlKilepInsert = "INSERT INTO `kilepett` (`k_id`, `d_nev`, `t_id`, `p_id`, `a_id`, `k_datum`) VALUES (NULL, '".$nev."', '".$t_id."', '".$p_id."', '".$a_id."', '".$datum."');";
	$sqlKilepDeleteMegjegyzes = "DELETE FROM `megjegyzes` WHERE `megjegyzes`.`d_id` = '".$id."';";
	$sqlKilepDelete = "DELETE FROM `dolgozok` WHERE `dolgozok`.`d_id` = '".$id."';";

	if ($conn->query($sqlKilepInsert)) {
		if ($conn->query($sqlKilepDeleteMegjegyzes)) {
			if ($conn->query($sqlKilepDelete)) {
			echo "Sikeres Kiléptetés";
		}else{
			echo $conn -> error;
			}
		}else{
			echo $conn->error;
		}
	}else{
		echo "Minden Sikertelen";
	}
	mysqli_close($conn);
?>