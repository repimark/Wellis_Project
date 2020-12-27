<?php 
	session_start();
	include '../connect.php';
	$username = $conn->real_escape_string($_POST["uname"]);
	$password = $conn->real_escape_string($_POST["pword"]);
	$sql = "SELECT u_id, u_name, u_jog FROM users WHERE `u_name` = '".$username."' AND `u_pass` = MD5('".$password."')";
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0) {
		//echo "Sikeres";
		$user = mysqli_fetch_row($result);
		$_SESSION["jog"] = $user[2];
		$_SESSION["u_name"] = $user[1];
		$_SESSION["u_id"] = $user[0];
		//$_SESSION["u_name"] = $username;
		header("location:../index.php");
	}else{
		//echo "Csicska vagy menj innen";
		header("location:../login.php");
	}


?>