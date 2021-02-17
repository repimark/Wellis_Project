<?php  
include '../connect.php';
$terulet = $conn->real_escape_string($_GET["id"]);
$sql = "SELECT dolgozok.d_nev, terulet.t_elnevezes, pozicio.p_elnevezes FROM dolgozok, terulet, pozicio, allapot WHERE terulet.t_id = dolgozok.t_id AND pozicio.p_id = dolgozok.p_id AND allapot.a_id = dolgozok.a_id AND dolgozok.t_id = $terulet ORDER BY d_nev";
$setRec = mysqli_query($conn, $sql);
$ternev = '';  
$columnHeader = '';  
$columnHeader = "Nevek" . ";" . "Terulet" . ";" . "Pozicio" . ";";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    $ternev = $rec[1];
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . ";";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
header("Content-type: application/octet-stream; charset=UTF-8");  
header("Content-Disposition: attachment; filename=$ternev.xls");  
header("Pragma: no-cache"); 
header("Cache-Control: max-age=0");
header("Expires: 0");  
echo pack("CCC", 0xef, 0xbb, 0xbf);
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
 ?> 
 