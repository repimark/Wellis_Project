<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header('login.php');
} else {
    include '../connect.php';
    $output = array();
    
    //SELECT TERULET 
    $teruletek = "SELECT t_elnevezes, t_id FROM terulet";
    if ($teruletQry = $conn->query($teruletek)) {
        while ($rowTerulet = $teruletQry->fetch_assoc()) {
            //echo "<br/>" . $rowTerulet["t_elnevezes"];
            $dolgozokDB;
            $kolcsonzottDB;
            $kolcsonBelepoDB;
            $kolcsonEsDolgozoDB;
            $belepoDB;
            $mindenBelepoDB;
            $igenyekDB;
            $mindenkiDB;

           //array_push($output, "'{'nev':'".$rowTerulet["t_elnevezes"]."'");
            //$output += '"terulet": {';
            

            $dolgozok = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 1 AND t_id = " . $rowTerulet["t_id"] . " OR  a_id = 7 AND t_id = " . $rowTerulet["t_id"] . " OR a_id = 8 AND t_id = " . $rowTerulet["t_id"];
            if ($dolgozokQry = $conn->query($dolgozok)) {
                $dolgozokDB = $dolgozokQry->fetch_row();
                //echo " Dolgozók : " . $dolgozokDB[0] . " , ";
                //array_push($output ,'dolgozok:'.$dolgozokDB[0]);
            }

            $kolcsonzott = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 4 AND t_id = " . $rowTerulet["t_id"];
            if ($kolcsonzottQry = $conn->query($kolcsonzott)) {
                $kolcsonzottDB = $kolcsonzottQry->fetch_row();
                //echo " Kölcsönzött : " . $kolcsonzottDB[0] . " , ";
                //array_push($output, 'kolcsonzott:'.$kolcsonzottDB[0]);

            }

            $kolcsonEsDolgozo = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 4 AND t_id = " . $rowTerulet["t_id"] . " OR a_id = 1 AND t_id = " . $rowTerulet["t_id"];
            if ($kolcsonEsDolgozoQry = $conn->query($kolcsonEsDolgozo)) {
                $kolcsonEsDolgozoDB = $kolcsonEsDolgozoQry->fetch_row();
                //echo " Összes létszám : " . $kolcsonEsDolgozoDB[0] . " , ";
                //array_push($output, 'kolcsonzott-dolgozo:'.$kolcsonzottEsDolgozoDB[0]);
            }
            //$kolcsonEsDolgozoDB = (int)$dolgozokDB[0] + (int)$kolcsonzott[0];

            $belepo = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 5 AND t_id = " . $rowTerulet["t_id"];
            if ($belepoQry = $conn->query($belepo)) {
                $belepoDB = $belepoQry->fetch_row();
                //echo " Belépő létszám : " . $belepoDB[0] . " , ";
                //array_push($output, 'belepo:'.$belepoDB[0].'');
            }

            $kolcsonBelepo = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 6 AND t_id = " . $rowTerulet["t_id"];
            if ($kolcsonBelepoQry = $conn->query($kolcsonBelepo)) {
                $kolcsonBelepoDB = $kolcsonBelepoQry->fetch_row();
                //echo " Kölcsönzött belépő : " . $kolcsonBelepoDB[0] . " . ";
                //array_push($output, 'kolcsonzott-belepo:'.$kolcsonBelepoDB[0]);
            }

            $mindenBelepo = "SELECT COUNT(d_id) AS dolgzok FROM dolgozok WHERE a_id = 5 AND t_id = " . $rowTerulet["t_id"] . " OR a_id = 6 AND t_id = " . $rowTerulet["t_id"];
            if ($mindenBelepoQry = $conn->query($mindenBelepo)) {
                $mindenBelepoDB = $mindenBelepoQry->fetch_row();
                //echo " Minden belépő : " . $mindenBelepoDB[0] . " . ";
                //array_push($output, 'minden-belepo:'.$mindenBelepoDB[0]);
            }
            //$mindenBelepoDB = (int)$belepoDB[0] + (int)$kolcsonBelepoDB[0];
            $mindenki = "SELECT COUNT(d_id) AS mindenki FROM dolgozok WHERE t_id = ". $rowTerulet["t_id"];
            if($mindenkiQry = $conn->query($mindenki)){
                $mindenkiDB = $mindenkiQry->fetch_row();
            }
            $igenyek = "SELECT SUM(i_db) FROM igeny WHERE t_id = " . $rowTerulet["t_id"];
            if ($igenyekQry = $conn->query($igenyek)) {
                $igenyekDB = $igenyekQry->fetch_row();
                //echo " Igény : " . ((int)$igenyekDB[0] - (int)$kolcsonEsDolgozoDB[0]);
                
                //array_push($output, 'igeny:'.$igenyEredmeny.'');
                $igenyEredmeny = ((int)$igenyekDB[0] - (int)$mindenkiDB[0]);
            }
            
            $output[] = array('nev' => $rowTerulet["t_elnevezes"] ,'dolgozo'=>$dolgozokDB[0], 'kolcsonzott' => $kolcsonzottDB[0], 'dolgozo_kolcson' => $kolcsonEsDolgozoDB[0], 'belepo' => $belepoDB[0], 'kolcson_belepo' => $kolcsonBelepoDB[0], 'minden_belepo' => $mindenBelepoDB[0], 'igeny' => ((int)$igenyekDB[0] - (int)$mindenkiDB[0]));
            
        }
        //array_push($output, ']');
    }
    
    echo json_encode($output);
}
?>