<?php

session_start();
if(!isset($_SESSION['u_id'])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $id = $conn->real_escape_string($_POST["id"]);
    $szov = $conn->real_escape_string($_POST["szov"]);
    $sql = "UPDATE `terulet_megjegyzes` SET `tm_szoveg` = '$szov' WHERE `terulet_megjegyzes`.`t_id` = $id";
    if($qry = $conn->query($sql)){
        echo "Sikeres";
    }else{
        echo "Sikertelen";
    }
    $conn->close();
}
?>