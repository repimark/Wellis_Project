<?php 
include('connect.php');
$id = $conn->real_escape_string($_POST["t_id"]);
$sql  = "SELECT terulet.t_elnevezes as 'Terulet', terulet.t_id AS 'id' FROM terulet";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["id"] == $id) { ?>
				<option data-id="<?php echo $row["id"];?>" selected><?php echo $row["Terulet"];?></option>
<?php			
			}else{
?>
				<option data-id="<?php echo $row["id"];?>"><?php echo $row["Terulet"];?></option>
<?php								
			}
		}
	}
	else {
		echo "0 results";
	}
mysqli_close($conn);
 ?>