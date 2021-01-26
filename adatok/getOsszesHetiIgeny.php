<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $today = $conn->real_escape_string($_POST["today"]);
        for($i = 1 ; $i <=52; $i++){
            $sql = "SELECT COUNT(d_id) AS db FROM dolgozok WHERE a_id = 1 AND YEAR(b_datum) = YEAR('$today') AND WEEK(b_datum) = $i OR a_id = 5 AND YEAR(b_datum) = YEAR('$today') AND WEEK(b_datum) = $i";
            $qry = $conn->query($sql);
            $result = $qry->fetch_row();
            $RES[] = array('het' => $i, 'db' => (int)$result[0]);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>
