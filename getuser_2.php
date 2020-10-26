<?php 
	require('connect.php');
	$sql = "SELECT terulet.t_elnevezes as Terulet, pozicio.p_elnevezes as Pozicio, terulet.t_id AS tid , pozicio.p_id AS pid FROM pozicio, terulet WHERE pozicio.t_id=terulet.t_id";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo $result->num_rows;
		while($row = $result->fetch_assoc()) {
?>	
	<option class="terulet_valaszthato" data-id='<?php echo $row["tid"]."/".$row["pid"];?>'><?php echo $row["Terulet"]." / ".$row["Pozicio"];?></option>
<?php
	}
	}
	else {
		echo "0 results";
	}
	mysqli_close($conn);

?>