<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header('location:login.php');
} else {
    include '../connect.php';
    $datum = $conn->escape_string($_POST["today"]);
    $dataArray = array();
    $sqlTerulet = "SELECT t_id, t_elnevezes FROM terulet";
    $qryTerulet = $conn->query($sqlTerulet);
    while ($row_3 = mysqli_fetch_assoc($qryTerulet)) {
        $sqlAll = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE t_id = ".$row_3["t_id"];
        $sqlKilepett = "SELECT COUNT(d_nev) AS db FROM `kilepett` WHERE WEEK(k_datum) = WEEK('$datum') AND t_id = ".$row_3["t_id"];
        $sqlBelepo = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE WEEK(b_datum) = WEEK('$datum') AND t_id = ".$row_3["t_id"];

        $qryAll = $conn->query($sqlAll) or die("sikertelen");
        $qryKilepett = $conn->query($sqlKilepett) or die("sikertelen");
        $qryBelepo = $conn->query($sqlBelepo) or die("Sikertelen");
        
        $row_all = $qryAll->fetch_row();
        $row_1 = $qryKilepett->fetch_row();
        $row_2 = $qryBelepo->fetch_row();
        // SZÁMOLÁS 
        $atlagosLetszam = 1;
        if($row_all[0] > 0){
            $atlagosLetszam = (float)$row_all[0];
        }
        
        //echo $atlagosLetszam . '<br>';
        $kilepesi = ((float)$row_1[0] / $atlagosLetszam) * 100;
        $belepesi = (float)((int)$row_2[0] / (float)$atlagosLetszam) * 100;
        $dataArray[] = array('terulet' => $row_3["t_elnevezes"], 'be' => round((float)$belepesi, 0), 'ki' => round((float)$kilepesi, 0));
    }
    echo json_encode($dataArray);
}
?>