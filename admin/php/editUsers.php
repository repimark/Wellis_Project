<?php  
session_start();
if (!isset($_SESSION["a_id"])) {
	header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wellis Felhasználók kezelése</title>
	<?php include '../contents/links.php'; ?>
</head>
<body>
	<?php include '../contents/adminNavbar.php'; ?>
	<div class="container">
		
	</div>
</body>
</html>
<?php } ?>