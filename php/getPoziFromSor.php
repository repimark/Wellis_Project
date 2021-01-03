<?php 
	session_start();
	if (!isset($_SESSION["u_id"])) {
		header("location:../index.php");
	}else{

        $sid = $_POST["s_id"];
		include '../connect.php';
		$sql = "SELECT p.`p_id` AS p_id, p.`p_elnevezes` AS p_elnevezes FROM `pozicio` p, `Sorok` s, `k_terulet` k WHERE s.`s_id` = k.`s_id` AND k.`p_id` = p.`p_id` AND  s.`s_id` = '".$sid."'";
		$result = $conn->query($sql) or die("sikertelen lekérdezés");
		while($r = $result->fetch_assoc()){
    		$rows[] = $r;
		}
		if (!sizeof($rows) > 0) {
			$rows[] = "Ehhez nincs megfelelő cuccli";
		}
		echo json_encode($rows);
		mysqli_close($conn);
	}

?>