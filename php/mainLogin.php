<?php 
	session_start();
	include '../connect.php';
	$username = $conn->real_escape_string($_POST["uname"]);
	$password = $conn->real_escape_string($_POST["pword"]);
	$sql = "SELECT u_id FROM users WHERE `u_name` = '".$username."' AND `u_pass` = '".$password."'";
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0) {
		//echo "Sikeres";
		$_SESSION["u_id"] = $username;
		//$_SESSION["u_name"] = $username;
		header("location:../index.php");
	}else{
		//echo "Csicska vagy menj innen";
		header("location:../login.php");
	}


?>