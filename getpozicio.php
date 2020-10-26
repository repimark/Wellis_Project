<?php 
	require('connect.php');
	echo "<meta charset='utf-8'>";
	
	$sql = "SELECT * FROM pozicio";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
?>	
	<option id="<?php echo $row["t_id"];?>"><?php echo $row["t_elnevezes"];?></option>
<?php
	}
	}
	else {
		echo "0 results";
	}
	mysqli_close($conn);

?>