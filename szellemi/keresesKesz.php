<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $id = $conn->real_escape_string($_POST["id"]);
    $datum = $conn->real_escape_string($_POST["datum"]);
    $sql = "UPDATE `szellemi_kereses` SET `szk_allapot` = '1', `szk_kesz_datum` = '$datum' WHERE `szellemi_kereses`.`szk_id` = $id";
    if($qry = $conn->query($sql)){
        echo "Sikeres";
    }else{
        echo "Sikertelen";
    } 
}
?>