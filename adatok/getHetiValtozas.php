<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $today = $conn->real_escape_string($_POST["today"]);
        //$today = '2020.12.26';
        $sqlGetTerulet = "SELECT t_id, t_elnevezes FROM terulet";
        $teruletQry = $conn->query($sqlGetTerulet); 
        while($row = $teruletQry->fetch_assoc()){
            $sql = "SELECT COUNT(k_id) AS db FROM `kilepett` WHERE t_id = '".$row["t_id"]."' AND YEAR(k_datum) = YEAR('$today') AND WEEK(k_datum) = WEEK('$today')";
            $qry = $conn->query($sql);
            $result = $qry->fetch_row();
            $sql1 = "SELECT COUNT(d_id) AS db FROM `dolgozok` WHERE t_id = '".$row["t_id"]."' AND YEAR(b_datum) = YEAR('$today') AND WEEK(b_datum) = WEEK('$today')";
            $qry1 = $conn->query($sql1);
            $result1 = $qry1->fetch_row();
            $RES[] = array('terulet' => $row["t_elnevezes"], 'kilep' => (int)$result[0], 'belep' => (int)$result1[0]);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>