<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $RES = array();
    $sql = "SELECT szk_allapot, COUNT(szk_id) AS db FROM `szellemi_kereses` GROUP BY szk_allapot";
    $qry = $conn->query($sql);
    while($row = $qry->fetch_assoc()){
        $RES[] = array(
            'allapot' => $row["szk_allapot"],
            'db' => $row["db"]
        );
    }
    echo json_encode($RES);
}
?>