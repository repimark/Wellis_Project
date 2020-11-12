<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["t_id"];
		include '../../connect.php';
		$sql = "SELECT `p_elnevezes`,`p_id` FROM `pozicio` WHERE `t_id` = ".$id;
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