<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $year = $conn->real_escape_string($_POST["year"]);
        $month = $conn->real_escape_string($_POST["month"]);
        $sqlGetTerulet = "SELECT t_id, t_elnevezes FROM terulet";
        $teruletQry = $conn->query($sqlGetTerulet); 
        while($row = $teruletQry->fetch_assoc()){
            $sql = "SELECT COUNT(k_id) AS db FROM `kilepett` WHERE t_id = '".$row["t_id"]."' AND YEAR(k_datum) = '$year' AND MONTH(k_datum) = '$month'";
            $qry = $conn->query($sql);
            $result = $qry->fetch_row();
            $RES[] = array('terulet' => $row["t_elnevezes"], 'db' => (int)$result[0]);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>