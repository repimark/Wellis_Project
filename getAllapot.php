<?php 
include('connect.php');
$id = $_POST["a_id"];
$sql  = "SELECT allapot.a_elnevezes as 'Allapot', allapot.a_id AS 'id' FROM allapot";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["id"] == $id) { ?>
				<option data-id="<?php echo $row["id"];?>" selected><?php echo $row["Allapot"];?></option>
<?php			
			}else{
?>
				<option data-id="<?php echo $row["id"];?>"><?php echo $row["Allapot"];?></option>
<?php								
			}
		}
	}
	else {
		echo "0 results";
	}
mysqli_close($conn);
 ?>