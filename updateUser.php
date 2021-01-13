<?php 

include('connect.php');
$id = $conn->real_escape_string($_POST["d_id"]);
$nev = $conn->real_escape_string($_POST["d_nev"]);
$pozi = $conn->real_escape_string($_POST["p_id"]);
$terulet = $conn->real_escape_string($_POST["t_id"]);
$allapot = $conn->real_escape_string($_POST["a_id"]);
$belepes = $conn->real_escape_string($_POST["belepes"]);

echo $id.",".$nev.",".$terulet.",".$pozi.",".$allapot;
$sql = " UPDATE dolgozok SET d_nev= '".$nev."', p_id = '".$pozi."', t_id = '".$terulet."', a_id = '".$allapot."', b_datum = '".$belepes."' WHERE dolgozok.d_id = ".$id."";
echo $sql;
$conn->query($sql) or die ("Nem működik");
mysqli_close($conn);
?>