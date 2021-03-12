<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $id = $conn->real_escape_string($_POST["id"]);
        $cim = $conn->real_escape_string($_POST["cim"]);
        $szoveg = $conn->real_escape_string($_POST["szov"]);
        date_default_timezone_set("Europe/Budapest");
        $datum = date("Y-m-d");
        $sql = "UPDATE `faq` SET `faq_title` = '$cim', `faq_cont` = '$szoveg', `faq_date` = '$datum' WHERE `faq`.`faq_id` = $id";
        if($conn->query($sql)) {
            echo "Sikeres";
        }
        $conn->close();
    }
?>

