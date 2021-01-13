<?php
session_start();
if (!isset($_SESSION["u_id"])) {
    header("location:../login.php");
} else {
    include '../connect.php';
    $nev = $conn->real_escape_string($_POST["nev"]);
    $sql = "SELECT terulet.t_elnevezes, pozicio.p_elnevezes, dolgozok.d_nev FROM dolgozok, terulet, pozicio WHERE terulet.t_id = dolgozok.t_id AND pozicio.p_id = dolgozok.p_id AND d_nev LIKE '%$nev%'";
    if ($qry = $conn->query($sql)) {
        while ($row = $qry->fetch_assoc()) {
            echo "<p>Név: <strong>" . $row["d_nev"] . "</strong> Terület: <strong>" . $row["t_elnevezes"] . "</strong> Pozició: <strong>" . $row["p_elnevezes"] . "</strong> .</p>";
        }
    } else {
        echo "Nincs ilyen dolgozó";
    }
    $conn->close();
}
?>
