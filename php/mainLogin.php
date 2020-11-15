<?php 
	session_start();
	$username = $_POST["uname"];
	$password = $_POST["pword"];
	$sql = "SELECT u_id FROM users WHERE `u_name` = '".$username."' AND `u_pass` = '".$password."'";
	include '../connect.php';
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