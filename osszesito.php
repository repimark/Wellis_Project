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
		include("contents/navbar.php");
		?>
		<div class="container">
			<h1 class="text-center p-5">Összesítő oldal </h1>
			<div id="osszesito"></div>
		</div>
		<script>
			$('.container').ready(function() {
				//alert('betöltött');
				getOsszesito()
			});
			var getOsszesito = function(){
				console.log("Belépett")
				$.ajax({
						url: 'php/getOsszesito.php',
						type: 'POST',
						cache: false,
						success: function(SorResult) {
							console.log(SorResult)
							var osszDolgozo = 0;
							var osszKolcson = 0;
							var osszBelepo = 0;
							var osszkBelepo = 0;
							var osszIgeny = 0;
							var obj = JSON.parse(SorResult);
							var lines = [];
							lines += '<table class="table table-light table-striped">'
							lines += '<thead class="thead-dark"><tr>'
							lines += '<th>Terület</th><th>Saját Létszám</th><th>Kölcsönzött Létszám</th><th class="text-danger">Összes Létszám</th><th>Belépő Létszám</th><th>Kölcsönzött belépő létszám</th><th class="text-danger">Összes Belépő</th><th>Igény</th></tr></thead>'
							lines += '<tbody>'
							if (obj.length > 0) {
								console.log('nagyobb a cucli')
								for (var i = 0; i <= obj.length - 1; i++) {
									lines += '<tr><td>' + obj[i].nev + '</td><td>' + obj[i].dolgozo + '</td><td>' + obj[i].kolcsonzott + '</td><td class="text-danger">' + obj[i].dolgozo_kolcson + '</td><td>'+ obj[i].belepo + '</td><td>' + obj[i].kolcson_belepo + '</td><td class="text-danger">' + obj[i].minden_belepo + '</td><td>' + obj[i].igeny + '</td></tr>'
									osszDolgozo += parseInt(obj[i].dolgozo)
									osszKolcson += parseInt(obj[i].kolcsonzott)
									osszBelepo += parseInt(obj[i].belepo)
									osszkBelepo += parseInt(obj[i].kolcson_belepo)
									osszIgeny += parseInt(obj[i].igeny)
								}
								lines += '<tr><td>Összesen</td><td>' + osszDolgozo + '</td><td>' + osszKolcson + '</td><td>' + (osszKolcson + osszDolgozo) + '</td><td>' + osszBelepo + '</td><td>' + osszkBelepo + '</td><td>' + (osszBelepo + osszkBelepo) + '</td><td>' + osszIgeny + '</td></tr>'
								lines += '</tbody></table>'
							} else {
								lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
							}
							$('#osszesito').html(lines)
						}
					});
			}
		</script>
	</body>

	</html>
<?php } ?>