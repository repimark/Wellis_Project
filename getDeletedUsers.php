<?php 
	include("connect.php");
	$sql = "SELECT kilepett.b_datum AS 'be', kilepett.d_nev AS 'nev', kilepett.k_datum AS 'datum', terulet.t_elnevezes AS 'terulet', pozicio.p_elnevezes AS 'pozicio', pozicio.p_id AS 'pid', terulet.t_id AS 'tid', kilepett.k_id AS 'kid', kilepett.a_id AS 'aid'  FROM kilepett, terulet, pozicio WHERE kilepett.p_id = pozicio.p_id AND kilepett.t_id = terulet.t_id ORDER BY kilepett.k_datum DESC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	?>
		<tr class="">
			<td><?php echo $row["nev"];?></td>
			<td><?php echo $row["terulet"];?></td>
			<td><?php echo $row["pozicio"];?></td>
			<td><?php echo $row["datum"];?></td>
			<td><?php echo $row["be"];?></td>
			<td><button type="button" class="btn btn-info visszaVon" data-allapot="<?php echo $row['aid'];?>" data-kid="<?php echo $row['kid'];?>" data-nev="<?php echo $row['nev'] ?>" data-datum="<?php echo $row['be'];?>" data-pozi="<?php echo $row['pid'];?>" data-terulet="<?php echo $row['tid'];?>">Visszavonás</button></td>
		</tr>
	<?php 
	}
	mysqli_close($conn);

 ?>