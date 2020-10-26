<?php
require('connect.php');

$sql = "SELECT terulet.t_elnevezes AS terulet, t_id FROM terulet WHERE terulet.t_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($terulet, $id);
echo "<select class='form-control' id='exampleFormControlSelect1'>";
while ($result = $stmt->fetch_assoc()) {
	echo "<option id=".$row["t_id"].">".$row["terulet"]."</option>";
}
echo "</select>";
$stmt->close();

?>