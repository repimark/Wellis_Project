<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header('location:login.php');
} else {
    include '../connect.php';
    $ev = $conn->escape_string($_GET["ev"]);
    $honap = $conn->escape_string($_GET["honap"]);
    $dataArray = array();
    $sqlTerulet = "SELECT t_id, t_elnevezes FROM terulet";
    $qryTerulet = $conn->query($sqlTerulet);
    while ($row_3 = mysqli_fetch_assoc($qryTerulet)) {

        $sqlKilepett = "SELECT COUNT(d_nev) AS db FROM `kilepett` WHERE YEAR(k_datum) = $ev AND t_id = ".$row_3["t_id"]." AND MONTH(k_datum) = $honap";
        $sqlBelepo = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE YEAR(b_datum) = $ev AND t_id = " . $row_3["t_id"] . " AND MONTH(b_datum) = $honap";

        $qryKilepett = $conn->query($sqlKilepett) or die("sikertelen");
        $qryBelepo = $conn->query($sqlBelepo) or die("Sikertelen");
        
        $row_1 = $qryKilepett->fetch_row();
        $row_2 = $qryBelepo->fetch_row();
        // SZÁMOLÁS 
        $atlagosLetszam = 400;
        $kilepesi = ((float)$row_1[0] / $atlagosLetszam) * 100;
        $belepesi = (float)((int)$row_2[0] / (float)$atlagosLetszam) * 100;
        $dataArray[] = array('terulet' => $row_3["t_elnevezes"], 'be' => (float)$belepesi, 'ki' => $kilepesi);
    }
    echo json_encode($dataArray);
}
?>