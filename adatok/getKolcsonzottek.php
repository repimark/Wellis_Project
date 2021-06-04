<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $meli = 0;
        $trank = 0;
        $munkal = 0;
        $getw = 0;
        $whc = 0;
        $ismeretlen = 0;
        $sql = "SELECT d_nev FROM dolgozok WHERE a_id = 4 OR a_id = 6";
        $qry = $conn->query($sql);
        while($row = $qry->fetch_assoc()){
            $nev = substr($row["d_nev"], -3);
            //echo $nev;
            if($nev == "kaL"){
                $munkal++;
            }else if($nev == " TW"){
                $trank++;
            }else if($nev == "com"){
                $meli++;
            }else if($nev == " GW"){
                $getw++;
            }else if($nev == "WHC"){
                $whc++;
            }else{
                $ismeretlen++;
            }
            
            
        }
        //echo "MunkaLand: ".$munkal.", Melicom: ".$meli.", TrankWalder: ".$trank.", Work4ce: ".$workf.", Ismeretlen cég: ".$ismeretlen;
        $RES[] = array('ml' => $munkal, 'meli' => $meli, 'trank' => $trank, 'getw' => $getw, 'ism' => $ismeretlen, 'whc' => $whc);
        echo json_encode($RES);
        $conn->close();
    }
?>