<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		die;
	}else{
		include '../../connect.php';
		$sql = "SELECT `t_elnevezes`, `p_elnevezes`, `pozicio`.`p_id`, `terulet`.`t_id` FROM `terulet`, `pozicio` WHERE `pozicio`.`t_id` = `terulet`.`t_id`";
		$result = $conn->query($sql);
		while($r = mysqli_fetch_assoc($result)) {
    		$rows[] = $r;
		}
		echo json_encode($rows);
		mysqli_close($conn);
	}

?>