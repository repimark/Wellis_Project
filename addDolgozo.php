<?php 
	include("connect.php");
	$nev = $_POST["d_nev"];
	$pozicio = $conn->real_escape_string($_POST["p_id"]);
	$terulet = $conn->real_escape_string($_POST["t_id"]);
	$allapot = $conn->real_escape_string($_POST["a_id"]);
	$datum = $conn->real_escape_string($_POST["b_datum"]);
	$sql = "INSERT INTO `dolgozok` (`d_id`, `d_nev`, `t_id`,`p_id`,`a_id`,`b_datum`) VALUES 
(NULL, '".$nev."', '".$terulet."', '".$pozicio."', '".$allapot."', '".$datum."')";
	if ($conn->query($sql)) {
		echo "Sikeres";
	}else{
		echo "Sikertelen";
		echo $conn->error;
	}
mysqli_close($conn);
?>