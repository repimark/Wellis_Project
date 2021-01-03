<!DOCTYPE html>
<html>

<head>
	<title>Dolgozók</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<meta charset="utf-8" />
</head>

<body>
	<?php
	include("contents/navbar.php");
	include 'connect.php';
	?>
	<h1>Dolgozók</h1>
	<div class="container-sm">
		<table border=1 class='table table-striped'>
			<thead class="thead-dark">
				<th>Név</th>
				<th>Pozíció</th>
				<th>Állapot</th>
				<th>Terület</th>
			</thead>
			<tbody>
				<?php
				require('connect.php');
				$sql_dolgozok = "SELECT dolgozok.d_nev AS 'nev', pozicio.p_elnevezes AS 'pozi', allapot.a_elnevezes AS 'állapot', dolgozok.a_id AS 'állapot_id', terulet.t_elnevezes AS 'terület' FROM dolgozok, pozicio, allapot, terulet WHERE dolgozok.a_id = allapot.a_id AND dolgozok.p_id = pozicio.p_id AND dolgozok.t_id = terulet.t_id";
				$result = $conn->query($sql_dolgozok);
				$conn->set_charset('utf-8');
				$db = 0;
				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						echo "<tr><td>" . $row["nev"] . "</td><td>" . $row["pozi"] . "</td><td>" . $row["állapot"] . "</td><td>" . $row["terület"] . "</td></tr>";
						if ($row["állapot_id"] == "1") {
							$db++;
						}
					}
				} else {
					echo "0 results";
				}
				?>
			</tbody>
		</table>
	</div>

	<form>
		<div class="form-group container-sm">
			<select id="terulet_select" class="form-control"></select>
		</div>
	</form>
	<br>
	<script type="text/javascript">
		$.ajax({
			url: "getuser_2.php",
			type: "POST",
			cache: false,
			success: function(data) {
				//alert(data);
				$('#terulet_select').html(data);
			}
		});
		$(document).on('change', '#terulet_select', function(e) {
			var id = $(this).children("option").attr("id");
			//var id_2=$(this).children().childre.attr("id");
			alert(id);

		});
	</script>
</body>

</html>