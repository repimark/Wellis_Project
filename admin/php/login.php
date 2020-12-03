<?php 
	session_start();
	include '../../connect.php';
	$username = $conn->real_escape_string($_POST["uname"]);
	$password = $conn->real_escape_string($_POST["pword"]);
	$sql = "SELECT a_id, a_name FROM admin WHERE `a_name` = '".$username."' AND `a_pass` = MD5('".$password."')";
	
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0) {
		//echo "Sikeres";
		$user = mysqli_fetch_row($result);
		$_SESSION["a_id"] = (int) $user[0];
		$_SESSION["a_name"] = (string) $user[1];
		header("location:../loggedIn.php");
	}else{
		//echo "Csicska vagy menj innen";
		header("location:../index.php");
	}


?>