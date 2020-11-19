<?php  
session_start();
if (!isset($_SESSION["u_id"])) {
	header("location: login.php");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wellis igényfelmérés</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="style.css">
  	<style type="text/css">
  		 .btn{
        background: #50C9C3;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to left, #96DEDA, #50C9C3);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to left, #96DEDA, #50C9C3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        color: black;
      }
  	</style>
</head>
<body>
	<?php 
		include("contents/navbar.php");
		include("connect.php");
	 ?>
	<div class="container w-50 bg-light rounded p-5 m-5">
		<h3 class="text-center">Új Dolgozó hozzáadása</h3>
	<form class="">
	  <div class="form-group">
	    <label for="dolgozoNev">Név</label>
	    <input type="text" class="form-control" id="dolgozoNev" placeholder="Teljes Név" required autofocus>
	  </div>
	  <div class="form-group">
	    <label for="teruletSelect">Terület</label>
	    <select class="form-control" id="teruletSelect" required>
	    	<?php 
	    		$result = $conn->query("SELECT terulet.t_elnevezes AS terulet, t_id FROM terulet");
	    		while($row = $result->fetch_assoc()) {
    				echo "<option data-id=".$row["t_id"].">".$row["terulet"]."</option>";
  				}
  			?>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="pozicioSelect">Pozíció</label>
	    <select class="form-control" id="pozicioSelect" required>
	      <!-- PHP BETÖLTI AZ TERÜLET ALAPJÁN A POZICÍÓKAT -->
	    </select>
	  </div>
	  <div class="form-group">
	  	<label for="allapotSelect">Állapot</label>
	  	<select class="form-control" id="allapotSelect" required>
	  		<?php 
	    		$result = $conn->query("SELECT a_id, a_elnevezes  FROM allapot");
	    		while($row = $result->fetch_assoc()) {
    				echo "<option data-id=".$row["a_id"].">".$row["a_elnevezes"]."</option>";
  				}
  			?>
	  	</select>
	  </div>
	  <div class="form-group">
	  	<button type="button" class="btn" id="addDolgozoButton">Dolgozó Felvétele</button>
	  </div>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			updatePozicio()
		});
		var updatePozicio = function(){
			var terulet_id = $("#teruletSelect option:selected").data('id')
    		console.log(terulet_id)
    		$.ajax({
				url: "getPozicioForUserAdd.php",
				type: "POST",
				cache: false,
				data:{
					t_id: terulet_id
				},
				success: function(getPozicioResult){
					console.log(getPozicioResult);
					//alert("update success");
					$('#pozicioSelect').html(getPozicioResult);
			}
		
	});
    	}
			$("#teruletSelect").change(function(){
    		
    		updatePozicio()

  		});

		var kolcsonzottCeg = function(){
			if ($('#allapotSelect :selected').data('id') == '5') {
				alert('Kölcsönzött dolgozó')
			}
		}
  		$("#addDolgozoButton").click(function(){
  			var nev = $('#dolgozoNev').val()
  			var terulet = $('#teruletSelect option:selected').data('id')
  			var pozicio = $('#pozicioSelect option:selected').data('id')
  			var allapot = $('#allapotSelect option:selected').data('id')
  			$.ajax({
  				url: "addDolgozo.php",
  				type: "POST",
  				cache: false,
  				data:{
  					d_nev: nev,
  					t_id: terulet,
  					p_id: pozicio,
  					a_id: allapot
  				},
  				success: function(addDolgozoResult){
  					if (addDolgozoResult == 'Sikeres') {
  						alert("Sikerült fellvinni az új dolgozót")
  					}
  					console.log(addDolgozoResult)
  					location.reload()
  				}
  			});
  		});
	</script>
	</div>

</body>
</html>
<?php } ?>