<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $cim = $conn->real_escape_string($_POST["cim"]);
        $szoveg = $conn->real_escape_string($_POST["szov"]);
        date_default_timezone_set("Europe/Budapest");
        $datum = date("Y-m-d");
        $sql = "INSERT INTO `faq` (`faq_id`, `faq_title`, `faq_cont`, `faq_date`) VALUES (NULL, '$cim', '$szoveg', '$datum')";
        if( $conn->query($sql) ) {
            echo "Sikeres";
        }
        $conn->close();
    }
?>
