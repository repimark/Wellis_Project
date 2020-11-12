<?php  
session_start();
if (!isset($_SESSION["a_id"])) {
	//echo "Nincs itt semmi keresnivalód ! ";
	header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<?php include '../contents/links.php'; ?>
	<title>Admin Felület</title>
</head>
<body>
	<?php include '../contents/AdminNavbar.php'; ?>
	<div class="container p-3 text-center">
		<h1 class="p-5 text-center">Hello Belló ez itt az admin felület !!! :D </h1>
	</div>
</body>
</html>
<?php 
	} 
?>