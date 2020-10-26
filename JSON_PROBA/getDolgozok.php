<?php 
	require 'connect.php';
	$sql = "SELECT d_nev, t_elnevezes, p_elnevezes, a_elnevezes FROM dolgozok, pozicio, allapot, terulet WHERE dolgozok.p_id = pozicio.p_id AND dolgozok.a_id = allapot.a_id AND dolgozok.t_id = terulet.t_id";
	$result = $conn->query($sql);
	$dolgozok = [];
	while ($row = $result->fetch_Array()) {
		$dolgozok[] = $row;
	}
	header('Content-type:application/json;charset=utf-8');
	echo json_encode(['dolgozok' => $dolgozok]);

 ?>