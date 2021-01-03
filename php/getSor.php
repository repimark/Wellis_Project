<?php 
    include '../connect.php';
    $sql = "SELECT s.s_id AS id, s.s_elnevezes AS elnev FROM Sorok s";
    $qry = $conn->query($sql);
    $sor = array();
    while($row = mysqli_fetch_assoc($qry)){
        $sor[] = $row;
    }
    echo json_encode($sor);
    $conn->close();
?>