<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    $RES = array();
    include '../connect.php';
    $sql = "SELECT `szellemi_terulet`.`szt_id` AS t_id, `szellemi_terulet`.`szt_elnevezes` AS t_elnev FROM `szellemi_terulet`";
    $qry = $conn->query($sql);
    while($row = $qry->fetch_assoc()){
        $RES[] = array(
            'terulet' => $row["t_elnev"],
            't_id' => $row["t_id"]
        );
    }
    echo json_encode($RES);
}
?>