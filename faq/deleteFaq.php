<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $id = $conn->real_escape_string($_POST["id"]);
        
        $sql = "DELETE FROM faq WHERE faq_id = '$id'";
        if( $conn->query($sql) ) {
            echo "Sikeres";
        }
        $conn->close();
    }
?>
