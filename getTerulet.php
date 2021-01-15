<?php 
include("connect.php");
$sql = "SELECT terulet.t_elnevezes AS 'Terület', terulet.t_id AS 'id' FROM terulet";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		//echo $result->num_rows;
		while($row = $result->fetch_assoc()) {
			//SQL LEKÉRDEZÉSEK
			$sqligenyMennyiseg = "SELECT SUM(i_db) FROM `igeny` WHERE t_id = '".$row["id"]."'";
			$sqlDolgozoMennyiseg = "SELECT COUNT(d_id) FROM `dolgozok` WHERE t_id = '".$row["id"]."' AND a_id = '1' OR t_id = '".$row["id"]."' AND a_id = '3'";
			$sqlkolcsonzottMennyiseg = "SELECT COUNT(d_id) FROM `dolgozok` WHERE t_id = '".$row["id"]."' AND a_id = '4'";
			$sqlbelepoMennyiseg = "SELECT COUNT(d_id) FROM `dolgozok` WHERE t_id = '".$row["id"]."' AND a_id = '5' OR t_id = '".$row["id"]."' AND a_id = '6'";
			

			//QUERY FUTTATÁSOK
			$resultIgeny = $conn->query($sqligenyMennyiseg);
			$resultDolgozok = $conn->query($sqlDolgozoMennyiseg);
			$resultKolcsonzottDolgozok = $conn->query($sqlkolcsonzottMennyiseg);
			$resultbelepoDolgozok = $conn ->query($sqlbelepoMennyiseg);
			//$resultKolcsonzottDolgozok = $conn->query($sqlDolgozoMennyisegKolcson);
			// $resultKolcsonzottIgeny = $conn->query($sqligenyMennyisegKolcson);

			//FETCH ROW FUTTATÁS
			$igenyAdat = mysqli_fetch_row($resultIgeny);
			$dolgozAdat = mysqli_fetch_row($resultDolgozok);
			$kolcsonzottAdat = mysqli_fetch_row($resultKolcsonzottDolgozok);
			$belepoAdat = mysqli_fetch_row($resultbelepoDolgozok);

			//$kolcsonzottAdat = mysqli_fetch_row($resultKolcsonzottDolgozok);
			// $kolcsonzottIgenyAdat = mysqli_fetch_row($resultKolcsonzottIgeny);

			//ADATOK KINYERÉSE
			$dolgozoMenny = (int) $dolgozAdat[0];
			$kolcsonzottMenny = (int)$kolcsonzottAdat[0];
			$belepoMenny = (int)$belepoAdat[0];
			$igenyMenny = (int) $igenyAdat[0] - $dolgozoMenny - $kolcsonzottMenny - $belepoMenny;
			if ($igenyMenny < 0) {
				$igenyMenny = 0;
			}
			//$kolcsonDolgozoMenny = (int) $kolcsonzottAdat[0];
			// $kolcsonIgenyMenny = (int) $kolcsonzottIgenyAdat[0] - $kolcsonDolgozoMenny;
			

			//Összegek
			$osszes = (int)$igenyAdat[0];
			// $kolcsonOsszes = $kolcsonDolgozoMenny + $kolcsonIgenyMenny;
?>	
	<div class="card mg-2 text-center shadow rounded " style="background: white; border:;">
			<div class="card-header bg-dark" style="border:none;color:white; ">
				<h5 class="text-white"><a style="text-decoration:none;" href="poziciokInfo.php?id=<?php echo $row['id'];?>"><?php echo $row["Terület"]; ?></a></h5>
			</div>
			<div class="card-body" style="background: #F8F8FF; border:none;">	
				<div class="container">
					<div class="row ">
						<div class="col" >
							<div align="center" id="t-<?php echo $row['id']; ?>" data-adat1="<?php echo $dolgozoMenny ?>" data-adat2="<?php echo $kolcsonzottMenny ?>" data-adat3="<?php echo $belepoMenny ?>" data-adat4="<?php echo $igenyMenny ?>"></div>
							  <script type="text/javascript">
								// Load Charts and the corechart package.
								      google.charts.load('current', {'packages':['corechart']});

								      // Draw the pie chart for Sarah's pizza when Charts is loaded.
								      google.charts.setOnLoadCallback(<?php echo "t".$row["id"]; ?>);

								      // Draw the pie chart for the Anthony's pizza when Charts is loaded.


								      // Callback that draws the pie chart for Sarah's pizza.
								      function <?php echo "t".$row["id"]; ?>() {
								      	var data1 = $('#t-<?php echo $row['id']; ?>').data('adat1')
								      	var data2 = $('#t-<?php echo $row['id']; ?>').data('adat2')
								      	var data3 = $('#t-<?php echo $row['id']; ?>').data('adat3')
								      	var data4 = $('#t-<?php echo $row['id']; ?>').data('adat4')
								        // Create the data table for Sarah's pizza.
								        var data = new google.visualization.DataTable();
								        data.addColumn('string', 'Topping');
								        data.addColumn('number', 'Slices');
								        data.addRows([
								          ['Dolgozók', data1],
								          ['Kölcsönzött', data2],
								          ['Belépő', data3],
								          ['Igény', data4]
								        ]);

								        // Set options for Sarah's pie chart.
								        var options = {
								        				
								                       	width:150,
								                       	height:150,
								                       	legend: 'none',
								                       	backgroundColor: '#F5F5F5',
								                        chartArea:{left:0,top:5,width:'100%',height:'90%'},
								                   		
								                   		colors: ['#9bdf46','#ad62aa','#FFB300','#d6d2c4']
								                   		};

								        // Instantiate and draw the chart for Sarah's pizza.
								        var chart = new google.visualization.PieChart(document.getElementById('t-<?php echo $row['id'];?>'));
								        chart.draw(data, options);
								      }
							</script>
    					</div>
    				</div>
    				<div class="p-2 row"></div>
				</div>
				<a class="btn-reszletek btn" data-toggle="collapse" data-target="#c<?php echo $row['id'];?>" aria-expanded="false" aria-controls="collapseExample" style="">Részletek</a>
			</div>
			<div class="collapse" id="c<?php echo $row['id'];?>">
  				<div class="card card-body text-dark">
  					<?php if (vanMegjegyzes){ ?>
  						<?php 
  							
  						?>
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