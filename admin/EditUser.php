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
		<h1 class="text-center">Felhasználói fiókom kezelése</h1>
	</div>
	<script type="text/javascript">
		$('.container').ready(function(){
			
		});
		
	</script>
</body>
</html>
<?php } ?>