<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $sqlGetTerulet = "SELECT k_datum, b_datum, d_nev, DATEDIFF(k_datum, b_datum) AS nap FROM `kilepett`";
        $teruletQry = $conn->query($sqlGetTerulet); 
        while($row = $teruletQry->fetch_assoc()){
            $RES[] = array('nev' => $row["d_nev"], 'db' => $row["nap"]);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>