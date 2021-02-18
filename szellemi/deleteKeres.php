<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $id = $conn->real_escape_string($_POST["id"]);
    $sql = "DELETE FROM `szellemi_kereses` WHERE `szk_id` = ".$id;
    if($qry = $conn->query($sql)){
        echo "Sikeres";
    }else{
        echo "Sikertelen";
    }
}
?>