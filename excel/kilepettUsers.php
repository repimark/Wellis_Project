<?php  
include '../connect.php';
$sql = "SELECT kilepett.d_nev, terulet.t_elnevezes, pozicio.p_elnevezes, allapot.a_elnevezes, kilepett.k_datum FROM kilepett, terulet, pozicio, allapot WHERE terulet.t_id = kilepett.t_id AND pozicio.p_id = kilepett.p_id AND allapot.a_id = kilepett.a_id ORDER BY d_nev";
$setRec = mysqli_query($conn, $sql);
$ternev = '';  
$columnHeader = '';  
$columnHeader = "Név" . "\t" . "Terulet" . "\t" . "Pozicio" . "\t" . "Állapot" . "\t". "Dátum";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    $ternev = $rec[1];
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
header("Content-type: application/octet-stream; charset=UTF-8");  
header("Content-Disposition: attachment; filename=Kilepett_Export.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  
echo pack("CCC", 0xef, 0xbb, 0xbf);
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
 ?> 
 