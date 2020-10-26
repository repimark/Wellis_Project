<?php 
	include('connect.php');
	$terulet = $_POST["t_id"];
	$pozicio = $_POST["p_id"];
	$sql = "SELECT pozicio.p_id AS 'p_id', pozicio.p_elnevezes AS 'pozicio' FROM pozicio WHERE pozicio.t_id = ".$terulet."";
	$result = $conn->query($sql);
   		while($row = $result->fetch_assoc()) {
			if ($row["p_id"] == $pozicio) {
				echo "<option data-id=".$row["p_id"]." selected>".$row["pozicio"]."</option>";
			}else{
				echo "<option data-id=".$row["p_id"].">".$row["pozicio"]."</option>";
			}
  		}
  	mysqli_close($conn);
?>