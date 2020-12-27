<?php
session_start();
if(!isset($_SESSION['u_id'])){
    header('location:login.php');
}else{
    include '../connect.php';
    $ev = $conn->escape_string($_GET["ev"]);
    $honap = $conn->escape_string($_GET["honap"]);
    $kovihonap = $honap + 1;

    $sqlKilepett = "SELECT COUNT(d_nev) AS db FROM `kilepett` WHERE YEAR(k_datum) = $ev AND MONTH(k_datum) < $kovihonap AND MONTH(k_datum) >= $honap";
    $sqlBelepo = "SELECT COUNT(d_nev) AS db FROM `dolgozok` WHERE YEAR(b_datum) = $ev AND MONTH(b_datum) < $kovihonap AND MONTH(b_datum) >= $honap";
    $sqlDolgozok = "SELECT * FROM dolgozok WHERE a_id = 4";
    //echo $sqlKilepett."\n";
    
    $qryKilepett = $conn->query($sqlKilepett) or die("sikertelen");
    $qryBelepo = $conn->query($sqlBelepo) or die("Sikertelen");
    $qryDolgozok = $conn->query($sqlDolgozok) or die("Dolgozok off");
    $row_1 = $qryKilepett->fetch_row();
    $row_2 = $qryBelepo->fetch_row();
    $dataArray = array();
    while ($row_3 = mysqli_fetch_assoc($qryDolgozok)){
        $dataArray[] = $row_3;
    }

    //echo "A decemberi kilépők száma : $row_1[0]. \n";
    echo json_encode($dataArray);
    //SELECT COUNT(d_nev) FROM `kilepett` WHERE MONTH(k_datum) < 12 AND MONTH(k_datum) >= 11
    // -
    ////SELECT COUNT(d_nev) FROM `dolgozok` WHERE MONTH(b_datum) < 12 AND MONTH(b_datum) >= 11
}
?>