<?php 
	include('connect.php');
	$t_id = $_POST["t_id"];
	$p_id = $_POST["p_id"];
	$meny = $_POST["meny"];
	$sql = "INSERT INTO `igeny` (`i_id`, `i_db`, `p_id`, `t_id`) VALUES (NULL, '".$meny."', '".$p_id."', '".$t_id."');";
	$conn->query($sql) or die ("Nem működik");
	mysqli_close($conn);

?>