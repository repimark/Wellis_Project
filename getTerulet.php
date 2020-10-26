<?php 
include("connect.php");
$sql = "SELECT terulet.t_elnevezes AS 'Terület', terulet.t_id AS 'id' FROM terulet";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		//echo $result->num_rows;
		while($row = $result->fetch_assoc()) {
?>	
	<div class="card mg-1 text-center " style="background: #E9967A; border: none;">
			<div class="card-header bg-dribble" style="border:none; ">
				<h5 class="text-white"><a class="text-muted streched-link text-secondary" href="poziciokInfo.php?id=<?php echo $row['id'];?>"><?php echo $row["Terület"]; ?></a></h5>
			</div>
			<div class="card-body" style="background: #F8F8FF; border:none;">	
				<div class="container">
					<div class="row ">
						<div class="col" >
							<div class="progress mx-auto" data-value='25'>
          						<span class="progress-left">
                        			<span class="progress-bar border-danger"></span>
          						</span>
          						<span class="progress-right">
                        			<span class="progress-bar border-danger"></span>
          						</span>
          					<div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            					<div class="h2 font-weight-bold">25<sup class="small">%</sup></div>
          					</div>
        					</div>
    					</div>
    				</div>
    				<div class="row p-2">
    					<div class="col">
        					<div class="progress mx-auto" data-value='40'>
          						<span class="progress-left">
                        			<span class="progress-bar border-danger"></span>
          						</span>
          						<span class="progress-right">
                        			<span class="progress-bar border-danger"></span>
          						</span>
          						<div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            						<div class="h2 font-weight-bold">40<sup class="small">%</sup></div>
          						</div>
        					</div>
    					</div>

						<!-- 				</div>
						<div class="col ">
							<p class="card-text">Jelenlegi fennmaradó igény <br> 13 fő</p>
						</div>
						</div>
						<div class="row">
						<div class="col ">
							<p class="card-text">Kölcsönzött létszám <br> 5 fő</p>
						</div>
						<div class="col">
							<p class="card-text">Kölcsönzött fennmaradó igény <br> 3 fő</p>
						</div>
						</div>
						<div class="row">
						<div class="col">
							<p class="card-text">Összes létszám <br> 45 fő</p>
						</div>
						<div class="col ">
							<p class="card-text">Összes fennmaradó igény <br> 16 fő </p>
						</div> -->
					</div>
				</div>
				<a class="btn text-monospace" data-toggle="collapse" data-target="#c<?php echo $row['id'];?>" aria-expanded="false" aria-controls="collapseExample" style="">Részletek</a>
			</div>
			<div class="collapse" id="c<?php echo $row['id'];?>">
  				<div class="card card-body text-dark">
  					<?php if (vanMegjegyzes){ ?>
  						<?php echo "van megjegyzes"; ?>
  					<?php }else{ ?>
  					<form>
  						<div class="form-group">
  							<label for="megjegyzes">Megjegyzés</label>
  							<input type="text" name="megjegyzes">
  						</div>
  						<div class="form-group">
  							<button class="btn btn-primary">Megjegyzés hozzáadása</button>
  						</div>
  					</form>
  					<?php } ?>			
    				<p class="card-text">Igény : <br> </p>
  				</div>
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