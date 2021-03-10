<?php 

include '../connect.php';
$RES = array();
//TERULET 
$teruletSQL = "SELECT t_id, t_elnevezes FROM terulet";
$teruletQRY = $conn->query($teruletSQL);
$setData = '';
while($terulet = $teruletQRY->fetch_assoc()){
    //POZICIO
    $pozicioSQL = "SELECT p_id, p_elnevezes FROM pozicio WHERE pozicio.t_id = ".$terulet["t_id"];
    $pozicioQRY = $conn->query($pozicioSQL);
    while($pozicio = $pozicioQRY->fetch_assoc()){
        //IGENY 
        $igenySQL = "SELECT i_db FROM igeny WHERE p_id = ".$pozicio["p_id"];
        $igenyQRY = $conn->query($igenySQL);
        $igeny = $igenyQRY->fetch_row();
        //DOLGOZOK
        $dolgozoSQL = "SELECT COUNT(d_id) AS 'db' FROM dolgozok WHERE p_id = ".$pozicio["p_id"];
        $dolgozoQRY = $conn->query($dolgozoSQL);
        $dolgozo = $dolgozoQRY->fetch_row();
        //SZÁMOLÁS
        $maradekIgeny = (int)$igeny[0] - (int)$dolgozo[0]; 
        //ARRAY
        //$RES[] = array("ter" => $terulet["t_elnevezes"], "poz" => $pozicio["p_elnevezes"], "ig" => $maradekIgeny);
        $setData .= $terulet["t_elnevezes"] . "\t" . $pozicio["p_elnevezes"] . "\t" . $maradekIgeny . "\n";
    }
    //$RES[] = array("ter" => '-', "poz" => '-', "ig" => '-');
    $setData .= "-" . "\t" . "-" . "\t" . "-" . "\n";
}
$columnHeader = "Terület" . "\t" . "Pozició" . "\t" . "Igény";
//echo json_encode($RES);
header("Content-type: application/octet-stream; charset=UTF-8");  
header("Content-Disposition: attachment; filename=Pozicionkenti_igenyek_Export.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  
echo pack("CCC", 0xef, 0xbb, 0xbf);
  echo ucwords($columnHeader) . "\n" . $setData . "\n";
?>
