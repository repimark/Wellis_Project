<?php 
	include("connect.php");
	$nev = $_POST["d_nev"];
	$pozicio = $_POST["p_id"];
	$terulet = $_POST["t_id"];
	$allapot = $_POST["a_id"];
	$sql = "INSERT INTO `dolgozok` (`d_id`, `d_nev`, `t_id`,`p_id`,`a_id`) VALUES 
(NULL, '".$nev."', '".$terulet."', '".$pozicio."', '".$allapot."')";
	if ($conn->query($sql)) {
		echo "Sikeres";
	}else{
		echo "Sikertelen";
	}
mysqli_close($conn);
?>