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
		<h1 class="text-center">Felhasználói fókok kezelése</h1>
		<div>
			<h3>Felhasználók</h3>
			<ul class="list-group" id="users">
				
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			getUsers()
		});
		var getUsers = function (){
			$.ajax({
				url: 'php/getUsers.php',
				type: 'POST',
				cache: false,
				success: function(Result){
					alert('csicska lángos')
				}
			});
		};
	</script>
</body>
</html>
<?php } ?>