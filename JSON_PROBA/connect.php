<?php 
// header('Content-Type: text/html; charset=utf-8');
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$db = 'alina_db';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
   // echo "Connected to MySQL successfully!";
}
?>