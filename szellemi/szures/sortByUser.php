<?php
session_start();
if(!isset($_SESSION["u_id"])){
    header("location: ../login.php");
}else{
    $RES = array();
    include '../connect.php';
    $felado = $conn->real_escape_string($_POST["felado"]);
    $sql = "SELECT `szellemi_kereses`.`szk_id` AS k_id, `szellemi_kereses`.`szk_pozicio` AS k_pozi, `szellemi_kereses`.`szk_datum` AS k_datum, `szellemi_kereses`.`szk_kesz_datum` AS k_kdatum, `szellemi_kereses`.`szk_allapot` AS k_allapot, `szellemi_terulet`.`szt_id` AS t_id, `szellemi_terulet`.`szt_elnevezes` AS t_elnev, `szellemi_kereses`.`szk_felado` AS felado FROM `szellemi_kereses`, `szellemi_terulet` WHERE `szellemi_terulet`.`szt_id` = `szellemi_kereses`.`szt_id` AND `szellemi_kereses`.`szk_felado` = '$felado'";
    $qry = $conn->query($sql);
    while($row = $qry->fetch_assoc()){
        $RES[] = array(
            'k_id' => $row["k_id"],
            'kezdDatum' => $row["k_datum"],
            'keszDatum' => $row["k_kdatum"], 
            'pozicio' => $row["k_pozi"], 
            'allapot' => $row["k_allapot"],
            'terulet' => $row["t_elnev"],
            't_id' => $row["t_id"],
            'felado' => $row["felado"]
        );
    }
    echo json_encode($RES);
}
?>