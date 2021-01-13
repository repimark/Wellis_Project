<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $meli = 0;
        $trank = 0;
        $workf = 0;
        $munkal = 0;
        $ismeretlen = 0;
        $sql = "SELECT d_nev FROM dolgozok WHERE a_id = 4 OR a_id = 6";
        $qry = $conn->query($sql);
        while($row = $qry->fetch_assoc()){
            $nev = substr($row["d_nev"], -2);
            //echo $nev;
            if($nev == " W"){
                $workf++;
            }else if($nev == "ML"){
                $munkal++;
            }else if($nev == " T"){
                $trank++;
            }else if($nev == " M"){
                $meli++;
            }else{
                $ismeretlen++;
            }
            //$RES[] = array('terulet' => $row["t_elnevezes"], 'db' => (int)$result[0]);
            
        }
        //echo "MunkaLand: ".$munkal.", Melicom: ".$meli.", TrankWalder: ".$trank.", Work4ce: ".$workf.", Ismeretlen cég: ".$ismeretlen;
        $RES[] = array('ml' => $munkal, 'meli' => $meli, 'trank' => $trank, 'workf' => $workf, 'ism' => $ismeretlen);
        echo json_encode($RES);
        $conn->close();
    }
?>