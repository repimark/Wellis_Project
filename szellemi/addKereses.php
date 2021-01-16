<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    include '../connect.php';
    $terulet = $conn->real_escape_string($_POST["terulet"]);
    $p_id = $conn->real_escape_string($_POST["pozi"]);
    $datum = $conn->real_escape_string($_POST["kDatum"]);
    $sql = "INSERT INTO `szellemi_kereses` (`szk_id`, `szt_id`, `szk_pozicio`, `szk_datum`, `szk_allapot`, `szk_kesz_datum`) VALUES (NULL, '$terulet', '$p_id', '$datum', 0, '')";
    if($qry = $conn->query($sql)){
        echo "Sikeres";
    }else{
        echo "Sikertelen";
    }
}
?>