<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:../login.php");
    }else{
        include '../connect.php';
        $RES = array();
        $sqlGetTerulet = "SELECT t_id, t_elnevezes FROM terulet";
        $teruletQry = $conn->query($sqlGetTerulet);
        while($ter = $teruletQry->fetch_assoc()){
            // allapot 1
            $allapotsql = "SELECT COUNT(d_id) as db FROM dolgozok WHERE a_id = 1 AND t_id = ".$ter["t_id"]." OR a_id = 3 AND t_id = ".$ter["t_id"]." OR a_id = 7 AND t_id = ".$ter["t_id"]." OR a_id = 8 AND t_id = ".$ter["t_id"];
            $qry1 = $conn->query($allapotsql);
            $result1 = $qry1->fetch_row();
            // allapot 2
            $allapotsql2 = "SELECT COUNT(d_id) as db FROM dolgozok WHERE a_id = 4 AND t_id = ".$ter["t_id"]."";
            $qry2 = $conn->query($allapotsql2);
            $result2 = $qry2->fetch_row();


            //allapot 3
            $allapotsql3 = "SELECT COUNT(d_id) as db FROM dolgozok WHERE a_id = 5 AND t_id = ".$ter["t_id"]." OR a_id = 6 AND t_id = ".$ter["t_id"];
            $qry3 = $conn->query($allapotsql3);
            $result3 = $qry3->fetch_row();

            //igeny
            $igeny = "SELECT SUM(i_db) FROM igeny WHERE t_id = ".$ter["t_id"];
            $qry4 = $conn->query($igeny);
            $result4 = $qry4->fetch_row();

            //mindenki
            $mindenki = "SELECT COUNT(d_id) as db FROM dolgozok WHERE t_id = ".$ter["t_id"];
            $qryMin = $conn->query($mindenki);
            $resMin = $qryMin->fetch_row();

            $newIgeny = (int)$result4[0] - (int)$resMin[0];
            //res kiiras
            $RES[] = array('terulet' => $ter["t_elnevezes"], 'sajat' => (int)$result1[0], 'kolcson' => (int)$result2[0], 'belepo' => $result3[0], 'igeny' => $newIgeny);
        }
        echo json_encode($RES);
        $conn->close();
    }
?>