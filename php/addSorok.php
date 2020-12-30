<?php 
    include '../connect.php';
    //Változók
    $poziciok = ["Jetelés","Belső Jet"," Dúsítás","Csövezés","Keretezés","Motorozás","Elektromos Szerelés","Felrakó", "Csomagolás"];
    $Sor;
    $newPoziIDS = array();
    //Sorok létrehozása !!
    $sorElnevezes = $conn->real_escape_string($_POST["sElnev"]);
    $insertSor = "INSERT INTO `Sorok` (`s_id`, `s_elnevezes`) VALUES (NULL, '$sorElnevezes')";
    if ($conn->query($insertSor)){
        //echo "Sikeres létrehozás";
        //Sor ID lekérdezése
        $selectSor = "SELECT `s_id` FROM `Sorok` ORDER BY `s_id` DESC LIMIT 0,1";
        $sorQry = $conn->query($selectSor);
        $sorRow = mysqli_fetch_row($sorQry);
        //echo $sorRow[0];
        $Sor = $sorRow[0];

        //Poziciok feltöltése
        foreach ($poziciok as $pozi){
            //echo "Belepett";
            $poziSQL = "INSERT INTO `pozicio` (`p_id`, `p_elnevezes`, `t_id`) VALUES (NULL, '$pozi', 7)";
            if ($conn->query($poziSQL)){
                //echo "$pozi sikeresen feltöltve";
            }
        }
        // Pozicio ID lekérdezése
        $selectPoziSQL = "SELECT `p_id` FROM `pozicio` ORDER BY `p_id` DESC LIMIT 0,9";
        $selPoziQRY = $conn->query($selectPoziSQL);
        while ($row = mysqli_fetch_assoc($selPoziQRY)) {
            //echo $row["p_id"];
            $newPoziIDS[] = $row;
        }

        for ($x = 0; $x < count($newPoziIDS); $x++){
            //echo "Belepett";
            //echo "INSERT INTO `k_terulet` (`kt_id`, `t_id`, `s_id`, `p_id`) VALUES (NULL, '7', '$Sor', '".$newPoziIDS[$x]["p_id"]."')";
            $kterSQL = "INSERT INTO `k_terulet` (`kt_id`, `t_id`, `s_id`, `p_id`) VALUES (NULL, '7', '$Sor', '".$newPoziIDS[$x]["p_id"]."')";
            if ($conn->query($kterSQL)){
                //echo "Sikerült feltölteni";
            }
        }

    }else{
        echo "Első lépés sikertelen";
    }

    $conn->close();

?>