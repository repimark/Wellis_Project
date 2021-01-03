<?php 
	session_start();
	if (!isset($_SESSION["u_id"])) {
		header("location:../index.php");
	}else{
        $id = $_POST["t_id"];
        $sid = $_POST["sor"];
		include '../connect.php';
		$sql = "SELECT `pozicio`.`p_elnevezes` AS p_elnevezes ,`pozicio`.`p_id` AS p_id FROM `pozicio`, `k_terulet`, `Sorok` WHERE `Sorok`.`s_id` = `k_terulet`.`s_id` AND `k_terulet`.`p_id` = `pozicio`.`p_id` AND  `pozicio`.`t_id` = ".$id." AND `Sorok`.`s_id` = '".$sid."' ORDER BY p_id DESC";
		$result = $conn->query($sql) or die("Sikertelen lekérdezés");
		while($r = mysqli_fetch_assoc($result)) {
    		$rows[] = $r;
		}
		if (!sizeof($rows) > 0) {
			$rows[] = "Ehhez nincs megfelelő cuccli";
		}
		echo json_encode($rows);
		mysqli_close($conn);
	}

?>