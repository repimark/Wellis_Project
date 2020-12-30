<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["t_id"];
		include '../../connect.php';
		$sql = "SELECT `pozicio`.`p_elnevezes` AS p_elnevezes ,`pozicio`.`p_id` AS p_id, `Sorok`.`s_elnevezes` AS s_elnevezes FROM `pozicio`, `k_terulet`, `Sorok` WHERE `Sorok`.`s_id` = `k_terulet`.`s_id` AND `k_terulet`.`p_id` = `pozicio`.`p_id` AND  `pozicio`.`t_id` = ".$id;
		$result = $conn->query($sql);
		while($r = mysqli_fetch_assoc($result)) {
    		$rows[] = $r;
		}
		if (!$rows.length > 0) {
			$rows[] = "Ehhez nincs megfelelő cuccli";
		}
		echo json_encode($rows);
		mysqli_close($conn);
	}

?>