<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $id = $conn->real_escape_string($_POST["id"]);
    $pozi = $conn->real_escape_string($_POST["pozi"]);
    $datum = $conn->real_escape_string($_POST["datum"]);
    $sql = "UPDATE `szellemi_kereses` SET `szk_datum` = '$datum', `szk_pozicio` = '$pozi' WHERE `szellemi_kereses`.`szk_id` = $id";
    if($qry = $conn->query($sql)){
        echo "Sikeres";
    }else{
        echo "Sikertelen";
    }
}
?>