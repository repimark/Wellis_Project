<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $dnev = $conn->real_escape_string($_POST["nev"]);
    $pozi = $conn->real_escape_string($_POST["pozi"]);
    $ter = $conn->real_escape_string($_POST["terulet"]);
    $allapot = $conn->real_escape_string($_POST["allapot"]);
    $datum = $conn->real_escape_string($_POST["datum"]);
    $kid = $conn->real_escape_string($_POST["kid"]);
    $sqlAdd = "INSERT INTO `dolgozok` (`d_id`, `d_nev`, `a_id`, `t_id`, `p_id`, `b_datum`) VALUES (NULL, '$dnev', '$allapot', '$ter', '$pozi', '$datum')";
    $sqlDelete = "DELETE FROM `kilepett` WHERE `kilepett`.`k_id` = $kid";
    if($conn->query($sqlAdd)){
        if($conn->query($sqlDelete)){
            echo "Sikeres";
        }else{
            echo "Törlés sikertelen";
        }
    }else{
        echo "létrehozás sikertelen";
    }
    $conn->close();
}
?>