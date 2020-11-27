<?php 
include('connect.php');
$id = $conn->real_escape_string($_POST["p_id"]);
$sql  = "SELECT pozicio.p_elnevezes as 'Pozicio', pozicio.p_id AS 'p_id', terulet.t_elnevezes AS 'Terulet', pozicio.t_id AS 't_id' FROM pozicio , terulet WHERE terulet.t_id = pozicio.t_id";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["p_id"] == $id) { ?>
				<option data-terulet="<?php echo $row['t_id'] ?>" data-pozicio="<?php echo $row["p_id"];?>" selected><?php echo $row["Pozicio"];?></option>
<?php			
			}else{
?>
				<option data-terulet="<?php echo $row['t_id'] ?>" data-pozicio="<?php echo $row["p_id"];?>"><?php echo $row["Terulet"]." / ".$row["Pozicio"];?></option>
<?php								
			}
		}
	}
	else {
		echo "0 results";
	}
mysqli_close($conn);
 ?>