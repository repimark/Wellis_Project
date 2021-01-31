<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    $RES = array();
    include '../connect.php';
    $sql = "SELECT `szellemi_kereses`.`szk_felado` AS felado FROM `szellemi_kereses` GROUP BY `szellemi_kereses`.`szk_felado`";
    $qry = $conn->query($sql);
    while($row = $qry->fetch_assoc()){
        $RES[] = array(
            'felado' => $row["felado"]
        );
    }
    echo json_encode($RES);
}
?>