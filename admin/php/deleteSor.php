<?php
    session_start();
    if(!isset($_SESSION["a_id"])){
        header('location:../index.php');
    }else{
        include '../../connect.php';
        $sid = $conn->real_escape_string($_GET["s_id"]);
        $getPoziSQL = "SELECT p_id FROM k_terulet WHERE s_id = ".$sid;
        $getPoziQRY = $conn->query($getPoziSQL);
        while($row = $getPoziQRY->fetch_assoc()){
            //echo $row["p_id"];
            $deleteIgeny = "DELETE FROM `igeny` WHERE `igeny`.`p_id` = ".$row["p_id"];
            if ($conn->query($deleteIgeny)){
                $deleteKPozicio = "DELETE FROM `pozicio` WHERE `pozicio`.`p_id` =".$row["p_id"];
                if($conn->query($deleteKPozicio)){
                    $deleteTerulet = "DELETE FROM `k_terulet` WHERE `k_terulet`.`p_id` =".$row["p_id"];
                    if($conn->query($deleteTerulet)){
                        echo "Sikeres";
                    }
                }
            }
        }
        $deleteSor = "DELETE FROM `Sorok` WHERE `Sorok`.`s_id` =".$sid;
        if ($conn->query($deleteSor)){
            echo "Sikeres Törlés";
        }




        $conn->close();
    }
