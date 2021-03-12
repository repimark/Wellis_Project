<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        
        $sql = "SELECT faq_id, faq_title, faq_cont FROM faq";
        $qry = $conn->query($sql);
        // $result = $qry->fetch_assoc();
        while($row = $qry->fetch_assoc()){
            $RES[] = array('id' => (int)$row["faq_id"], 'cim' => $row["faq_title"], 'szoveg' => $row["faq_cont"]);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>
