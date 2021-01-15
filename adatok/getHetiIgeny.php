<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $today = $conn->real_escape_string($_POST["today"]);
        //$today = '2020.12.26';
        $sql = "SELECT WEEK('$today') as het, COUNT(d_id) AS db FROM dolgozok WHERE YEAR(b_datum) = YEAR('$today') AND WEEK(b_datum) = WEEK('$today')";
        $qry = $conn->query($sql);
        $result = $qry->fetch_row();
        $RES[] = array('het' => (int)$result[0], 'db' => (int)$result[1]);
        echo json_encode($RES);
        $conn->close();
    }
?>