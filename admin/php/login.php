<?php 
	session_start();
	$username = $_POST["uname"];
	$password = $_POST["pword"];
	$sql = "SELECT a_id FROM admin WHERE `a_name` = '".$username."' AND `a_pass` = MD5('".$password."')";
	include '../../connect.php';
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0) {
		//echo "Sikeres";
		$_SESSION["a_id"] = $username;
		header("location:../loggedIn.php");
	}else{
		//echo "Csicska vagy menj innen";
		header("location:../index.php");
	}


?>