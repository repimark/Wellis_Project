<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$sql = "SELECT `t_elnevezes`,`t_id` FROM `terulet`";
		$result = $conn->query($sql);
		while($r = mysqli_fetch_assoc($result)) {
    		$rows[] = array('t_id' => $r["t_id"], 'telnev' => $r["t_elnevezes"]);
		}
		echo json_encode($rows);
		mysqli_close($conn);
	}

?>