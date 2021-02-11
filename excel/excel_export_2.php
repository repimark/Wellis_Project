<!-- <?php
// Connection 
session_start();
if (!isset($_SESSION["u_id"])) {
	header("location: login.php");
}else{
include '../connect.php';
$terulet = $conn->escape_string($_GET["id"]);
$filename = "Export.csv"; // File Name
// Download file
function cleanData(&$str)
{
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    $str = mb_convert_encoding($str, 'Windows-1252', 'UTF-8');
}
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv; charset=UTF-8");
$user_query = $conn->query("SELECT `dolgozok`.`d_nev` AS 'Név', `pozicio`.`p_elnevezes` AS 'Pozicíó' FROM `dolgozok`, `pozicio` WHERE `dolgozok`.`t_id` = '$terulet' AND `pozicio`.`p_id` = `dolgozok`.`p_id` ORDER BY `pozicio`.`p_elnevezes`");
// Write data to file
$flag = false;
$out = fopen("php://output", 'w');
while ($row = $user_query->fetch_assoc()) {
    if (!$flag) {
        array_walk($row, __NAMESPACE__ . '\cleanData');
        fputcsv($out, array_keys($row), ';', '"');
        $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    fputcsv($out, array_values($row), ';', '"');
}
fclose($out);
}
?> -->