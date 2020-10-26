<!DOCTYPE html>
<html>
<head>
	<title>Igény felvétele</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
	include('contents/navbar.php');
?>
	<div class="container-sm pd-5">
		<form class="w-50 p-3 mg-2">
			<div class="form-group">
				<label for="#teruletSelect">Terület</label>
				<select id="teruletSelect" class="form-control">
				<?php 
					include('connect.php');
					$id = $_POST["t_id"];
					$sql  = "SELECT terulet.t_elnevezes as 'Terulet', terulet.t_id AS 'id' FROM terulet";
					$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								if ($row["id"] == $id) { ?>
									<option data-id="<?php echo $row["id"];?>" selected><?php echo $row["Terulet"];?></option>
					<?php			
								}else{
					?>
									<option data-id="<?php echo $row["id"];?>"><?php echo $row["Terulet"];?></option>
					<?php								
								}
							}
						}
						else {
							echo "0 results";
						}
					mysqli_close($conn);
 				?>	
				</select>
			</div>
			<div class="form-group">
				<label for="#pozicioSelect">Pozició</label>
				<select id="pozicioSelect" class="form-control">
					
				</select>
			</div>
			<div class="form-group">
				<label for="igenydarab">Mennyiség</label>
				<input type="text" name="igenydarab" id="igenyDB" class="form-control" placeholder=".db">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" id="addIgenyButton">Igény felvitele</button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		// $(document).ready(function(){
		// 	$.ajax({
		// 		url: 'getUserTerulet.php',
		// 		type: 'POST',
		// 		cache: false,
		// 		data:{
		// 			t_id: 1
		// 		},
		// 		success: function(data){
		// 			//console.log(data)
		// 			$('#teruletSelect').html(data)
		// 		} 
		// 	});
		// });
		$("#teruletSelect").change(function(){
    		//alert('változott')
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
  		});
  		$('#addIgenyButton').click(function(){
  			var terulet = $('#teruletSelect option:selected').data('id')
  			var pozicio = $('#pozicioSelect option:selected').data('id')
  			var mennyiseg = $('#igenyDB').val()
  			console.log(''+terulet+' , '+pozicio+' , '+mennyiseg)
  			$.ajax({
  				url: 'igenyHozzaadasa.php',
  				type: "POST",
  				cache: false,
  				data: {
  					t_id: terulet,
  					p_id: pozicio,
  					meny: mennyiseg
  				},
  				success: function(DataResult){
  					//alert('Sikeres')
  					//console.log(DataResult)
  					location.reload()
  				}
  			});
  		});
	</script>
</body>
</html>