<?php
session_start();
if (!isset($_SESSION["u_id"])) {
	header("location: login.php");
} else {
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Wellis igényfelmérés</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">

	</head>

	<body>
		<?php
		//Ide kérjük be a fejlécet a menüt és az adatbázis kapcsolatot nyitjuk meg 
		if ($_SESSION["jog"] == "1") {
			require('contents/navbar.php');
		} else if ($_SESSION["jog"] == "2") {
			require('contents/userNavbar.php');
		}
		require('connect.php');
		?>
		<div class="container">
			<h1 class="text-center">Kilépett dolgozók</h1>
			<button class="btn btn-success" id="export">Excel export</button>
			<table border=1 class='table table-striped'>
				<thead class="thead-dark">
					<th>Név</th>
					<th>Terület</th>
					<th>Pozíció</th>
					<th>Kiléptetés dátum</th>
					<th>Beléptetés dátum</th>
					<th>Műveletek</th>
				</thead>
				<tbody class="table-dark">
					<!-- DOLGOZÓK KILISTÁZÁSA -->
					<?php include("getDeletedUsers.php"); ?>
				</tbody>
			</table>
		</div>
		<script>
			$('.container').ready(function(){
				userKezeles()
			})
			var userKezeles = function() {
				var jogosultsag = '<?php echo $_SESSION["jog"]; ?>'
				//alert(jogosultsag)
				if (jogosultsag == '2') {
					$('.btn').attr('disabled', true)
					$('.btn-block').attr('disabled', false)
					$('#addDolgozo').attr('disabled', true)
					$('#export').attr('disabled', false)
					//$('.addMegjegyzes').attr('disabled', false)
					//$('.accordion').collapse('toggle')
				}
			}
			$('.visszaVon').click(function() {
				var button = $(this)
				var ter = button.data('terulet')
				var poz = button.data('pozi')
				var nev = button.data('nev')
				var datum = button.data('datum')
				var all = button.data('allapot')
				var kid = button.data('kid')
				//alert('terulet:' + ter + ', Pozicio: ' + poz + ', Név: ' + nev + ', Dátum : '+ datum)	
				$.ajax({
					url: 'php/addUser.php',
					type: 'POST',
					data: {
						nev: nev,
						pozi: poz,
						terulet: ter,
						allapot: all,
						datum: datum,
						kid: kid
					},
					success: function(res) {
						alert(res)
						location.reload()
					},
					error: function(errorRes) {
						console.log(errorRes)
					}
				})
			})
			$('#export').click(function() {
				//alert("pressed")
				window.open("excel/kilepettUsers.php", "_blank")
			});
		</script>
	</body>

	</html>
<?php } ?>