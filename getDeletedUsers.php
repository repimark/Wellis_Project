<?php 
	include("connect.php");
	$sql = "SELECT kilepett.b_datum AS 'be', kilepett.d_nev AS 'nev', kilepett.k_datum AS 'datum', terulet.t_elnevezes AS 'terulet', pozicio.p_elnevezes AS 'pozicio'FROM kilepett, terulet, pozicio WHERE kilepett.p_id = pozicio.p_id AND kilepett.t_id = terulet.t_id ORDER BY kilepett.k_id DESC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	?>
		<tr class="">
			<td><?php echo $row["nev"];?></td>
			<td><?php echo $row["terulet"];?></td>
			<td><?php echo $row["pozicio"];?></td>
			<td><?php echo $row["datum"];?></td>
			<td><?php echo $row["be"];?></td>
		</tr>
	<?php 
	}
	mysqli_close($conn);

 ?>