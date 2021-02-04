<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header('location:login.php');
} else {
    include '../connect.php';
    $ev = $conn->real_escape_string($_GET["today"]);
    $dataArray = array();
    $sqlTerulet = "SELECT t_id, t_elnevezes FROM terulet";
    $qryTerulet = $conn->query($sqlTerulet);
    while ($row_3 = mysqli_fetch_assoc($qryTerulet)) {
        $sqlAll = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE t_id = ".$row_3["t_id"];
        $sqlKilepett = "SELECT COUNT(d_nev) AS db FROM `kilepett` WHERE t_id = ".$row_3["t_id"]." AND MONTH(k_datum) = MONTH('$ev')";
        $sqlBelepo = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE t_id = " . $row_3["t_id"] . " AND MONTH(b_datum) = MONTH('$ev')";

        $qryAll = $conn->query($sqlAll) or die("sikertelen 1");
        $qryKilepett = $conn->query($sqlKilepett) or die("sikertelen 2");
        $qryBelepo = $conn->query($sqlBelepo) or die("Sikertelen 3");
        
        $row_all = $qryAll->fetch_row();
        $row_1 = $qryKilepett->fetch_row();
        $row_2 = $qryBelepo->fetch_row();
        // SZÁMOLÁS 
        $atlagosLetszam = 1;
        if($row_all[0] > 0){
            $atlagosLetszam = (float)$row_all[0];
        }

        $kilepesi = (float)(((float)$row_1[0] * 100) / (float)$atlagosLetszam);
        $belepesi = (float)(((float)$row_2[0] * 100) / (float)$atlagosLetszam);
        $dataArray[] = array('terulet' => $row_3["t_elnevezes"], 'be' => round($belepesi, 2), 'ki' => round($kilepesi, 2));
    }
    echo json_encode($dataArray);
}
?>