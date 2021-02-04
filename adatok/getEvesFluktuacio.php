<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header('location:../login.php');
} else {
    include '../connect.php';
    //$ev = $conn->real_escape_string($_POST["today"]);
    $RES = array();
    $dataArray = array();
    $sqlTerulet = "SELECT t_id, t_elnevezes FROM terulet";
    $qryTerulet = $conn->query($sqlTerulet);
    while ($row_3 = mysqli_fetch_assoc($qryTerulet)) {
        for ($i = 1; $i <= 12; $i++) {
            $sqlAll = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE t_id = " . $row_3["t_id"];
            $sqlKilepett = "SELECT COUNT(d_nev) AS db FROM `kilepett` WHERE t_id = " . $row_3["t_id"] . " AND MONTH(k_datum) = MONTH('$i')";
            $sqlBelepo = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE t_id = " . $row_3["t_id"] . " AND MONTH(b_datum) = MONTH('$i')";

            $qryAll = $conn->query($sqlAll) or die("sikertelen 1");
            $qryKilepett = $conn->query($sqlKilepett) or die("sikertelen 2");
            $qryBelepo = $conn->query($sqlBelepo) or die("Sikertelen 3");

            $row_all = $qryAll->fetch_row();
            $row_1 = $qryKilepett->fetch_row();
            $row_2 = $qryBelepo->fetch_row();
            // SZÁMOLÁS 
            $atlagosLetszam = 1.5;
            if ($row_all[0] > 0) {
                $atlagosLetszam = (float)$row_all[0] - 10.5;
            }

            $kilepesi = (((float)$row_1[0] * 100.0 )/ (float)$atlagosLetszam);
            //$kilepesi = (float)$atlagosLetszam;
            $belepesi = (((float)$row_2[0]  * 100.25)  / (float)$atlagosLetszam) + 1.25;
            $dataArray[] = array('honap' => $i, 'terulet' => $row_3["t_elnevezes"], 'be' => (float)$belepesi, 'ki' => (float)$kilepesi);
        }
    }
    //header("Content-Type: application/json");
    echo json_encode($dataArray);
}
?>