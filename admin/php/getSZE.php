<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		$id = $_POST["t_id"];
		include '../../connect.php';
		$sql = "SELECT `szt_id`, `szt_elnevezes` FROM `szellemi_terulet`";
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