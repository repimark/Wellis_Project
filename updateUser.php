<?php 

include('connect.php');
$id = $_POST["d_id"];
$nev = $_POST["d_nev"];
$pozi = $_POST["p_id"];
$terulet = $_POST["t_id"];
$allapot = $_POST["a_id"];

echo $id.",".$nev.",".$terulet.",".$pozi.",".$allapot;
$sql = " UPDATE dolgozok SET d_nev= '".$nev."', p_id = '".$pozi."', t_id = '".$terulet."', a_id = '".$allapot."' WHERE dolgozok.d_id = ".$id."";
echo $sql;
$conn->query($sql) or die ("Nem működik");
mysqli_close($conn);
 ?>