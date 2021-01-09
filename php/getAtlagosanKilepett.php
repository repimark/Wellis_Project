<?php 
    session_start();
    if(!isset($_SESSION['u_id'])){
        header("location: index.php");
    }else{
        include '../connect.php';
        $ev = $conn->real_escape_string($_POST["ev"]);
        $sql = "SELECT COUNT(k_id) FROM `kilepett` WHERE YEAR(k_datum) = $ev";
        $qry = $conn->query($sql);
        $row = $qry->fetch_row();
        echo "$ev átlagosan kilépettek száma havonta : $row";
        
    }
?>