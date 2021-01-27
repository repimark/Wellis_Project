<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location: ../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $year = $conn->real_escape_string($_POST["year"]);
        $month = $conn->real_escape_string($_POST["month"]);
        $sql = "SELECT p.`p_elnevezes` AS pozi, i.`iv_muvelet` AS muv, COUNT(i.`iv_muvelet`) AS db FROM `igenyvaltozas_log` i, `pozicio` p WHERE i.`p_id` = p.`p_id` AND YEAR(i.`iv_datum`) = '$year' AND MONTH(i.`iv_datum`) = '$month' GROUP BY i.`iv_muvelet`, i.`p_id`";
        $qry = $conn->query($sql);
        while($row = $qry->fetch_assoc()){
            $RES[] = array('pozi' => $row["pozi"], 'muvelet' => $row["muv"], 'db' => $row["db"]);
        }
        echo json_encode($RES);
        
    }
?>