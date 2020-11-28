<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
	include('../../connect.php');
	$sql = "SELECT a_name, a_id FROM admin";
	$result = $conn->query($sql);
	while($r = mysqli_fetch_assoc($result)) {
    	$rows[] = $r;
	}
	echo json_encode($rows);
	mysqli_close($conn);
}
?>