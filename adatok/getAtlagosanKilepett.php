<?php 
    session_start();
    if(!isset($_SESSION['u_id'])){
        header("location: index.php");
    }else{
        include '../connect.php';
        $out = array();
        $honap = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"];
        if (isset($_POST["year"])){
            $ev = $conn->real_escape_string($_POST["year"]);
        }else{
            $ev = 2020;
        }
        for( $i = 1; $i < 13; $i++){
        $sql = "SELECT COUNT(k_id) FROM `kilepett` WHERE YEAR(k_datum) = $ev AND MONTH(k_datum) = $i";
        $qry = $conn->query($sql);
        $row = $qry->fetch_row();
        $out[] = array('honap' => $honap[$i-1], 'adat' => $row[0]);
        }
        echo json_encode($out);        
        $conn->close();
    }
?>