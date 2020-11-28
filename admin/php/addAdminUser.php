<?php 
	session_start();
	if (!isset($_SESSION["a_id"])) {
		header("location:../index.php");
	}else{
		include '../../connect.php';
		$nev = $conn->real_escape_string($_POST["aName"]);
		$jelszo = $conn->real_escape_string($_POST["aPass"]);
		$sql = "INSERT INTO `admin` (`a_id`, `a_name`, `a_pass`) VALUES (NULL, '".$nev."', MD5('".$jelszo."'))";
		if ($conn->query($sql)) {
			echo 'Sikeres';
		}
		mysqli_close($conn);
	}

?>