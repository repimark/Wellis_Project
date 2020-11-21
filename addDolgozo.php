<?php 
	include("connect.php");
	$nev = $_POST["d_nev"];
	$pozicio = $_POST["p_id"];
	$terulet = $_POST["t_id"];
	$allapot = $_POST["a_id"];
	$datum = $_POST["b_datum"];
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