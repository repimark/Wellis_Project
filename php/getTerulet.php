<?php 
include("../connect.php");
$sql = "SELECT terulet.t_elnevezes AS Terület FROM terulet";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo $result->num_rows;
		while($row = $result->fetch_assoc()) {
?>	
	<div class="card text-center text-white bg-info mb-3 w-25">
			<div class="card-header">
				<h5>MEO igények</h5>
			</div>
			<div class="card-body">	
				<p class="card-text"><?php echo $row["terület"]; ?>igények 100/75</p>
				<div class="progress">
	  				<div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<br>
				<!-- <p class="card-text">Meo Igények .d </p> -->
				<a class="btn btn-primary">Részletek</a>
			</div>
		</div>
<?php
	}
	}
	else {
		echo "0 results";
	}
	mysqli_close($conn);


 ?>