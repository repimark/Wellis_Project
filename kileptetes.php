<?php
include("connect.php");
$id = $conn->real_escape_string($_POST["d_id"]);
$nev = $conn->real_escape_string($_POST["nev"]);
$p_id = $conn->real_escape_string($_POST["p_id"]);
$t_id = $conn->real_escape_string($_POST["t_id"]);
$a_id = $conn->real_escape_string($_POST["a_id"]);
$datum = $conn->real_escape_string($_POST["datum"]);
$b_datum = $conn->real_escape_string($_POST["belepes"]);

$sqlKilepInsert = "INSERT INTO `kilepett` (`k_id`, `d_nev`, `t_id`, `p_id`, `a_id`, `k_datum`, `b_datum`) VALUES (NULL, '" . $nev . "', '" . $t_id . "', '" . $p_id . "', '" . $a_id . "', '" . $datum . "', '" . $b_datum . "');";
$sqlKilepDeleteMegjegyzes = "DELETE FROM `megjegyzes` WHERE `megjegyzes`.`d_id` = " . $id . ";";
$sqlKilepDelete = "DELETE FROM `dolgozok` WHERE `dolgozok`.`d_id` = '" . $id . "';";

if ($conn->query($sqlKilepInsert)) {
	if ($conn->query($sqlKilepDeleteMegjegyzes)) {
		if ($conn->query($sqlKilepDelete)) {
			echo "Sikeres Kiléptetés";
		} else {
			echo $conn->error;
		}
	} else {
		echo $conn->error;
	}
} else {
	echo "Minden Sikertelen";
}
$conn->close();
