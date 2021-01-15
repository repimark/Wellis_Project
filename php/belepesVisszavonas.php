<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("location: ../index.php");
} else {
    include("../connect.php");
    $id = $conn->real_escape_string($_POST["d_id"]);
   

    //$sqlKilepInsert = "INSERT INTO `kilepett` (`k_id`, `d_nev`, `t_id`, `p_id`, `a_id`, `k_datum`, `b_datum`) VALUES (NULL, '" . $nev . "', '" . $t_id . "', '" . $p_id . "', '" . $a_id . "', '" . $datum . "', '" . $b_datum . "');";
    $sqlKilepDeleteMegjegyzes = "DELETE FROM `megjegyzes` WHERE `megjegyzes`.`d_id` = '" . $id . "';";
    $sqlKilepDelete = "DELETE FROM `dolgozok` WHERE `dolgozok`.`d_id` = '" . $id . "';";

        if ($conn->query($sqlKilepDeleteMegjegyzes)) {
            if ($conn->query($sqlKilepDelete)) {
                echo "Sikeres Kiléptetés";
            } else {
                echo $conn->error;
            }
        } else {
            echo $conn->error;
        }
    $conn->close();
}
?>