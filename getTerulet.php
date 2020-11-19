<?php 
include("connect.php");
$sql = "SELECT terulet.t_elnevezes AS 'Terület', terulet.t_id AS 'id' FROM terulet";
$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		//echo $result->num_rows;
		while($row = $result->fetch_assoc()) {
			//SQL LEKÉRDEZÉSEK
			$sqligenyMennyiseg = "SELECT SUM(i_db) FROM `igeny` WHERE t_id = '".$row["id"]."'";
			$sqlDolgozoMennyiseg = "SELECT COUNT(d_id) FROM `dolgozok` WHERE t_id = '".$row["id"]."' AND a_id = '1' OR t_id = '".$row["id"]."' AND a_id = '3' OR t_id = '".$row["id"]."' AND a_id = '4'";
			// $sqligenyMennyisegKolcson = "SELECT SUM(i_db) FROM `igeny` WHERE t_id = '".$row["id"]."' AND i_sajat = '1'";
			//$sqlDolgozoMennyisegKolcson = "SELECT COUNT(d_id) FROM `dolgozok` WHERE t_id = '".$row["id"]."' AND a_id = '4'";

			//QUERY FUTTATÁSOK
			$resultIgeny = $conn->query($sqligenyMennyiseg);
			$resultDolgozok = $conn->query($sqlDolgozoMennyiseg);
			//$resultKolcsonzottDolgozok = $conn->query($sqlDolgozoMennyisegKolcson);
			// $resultKolcsonzottIgeny = $conn->query($sqligenyMennyisegKolcson);

			//FETCH ROW FUTTATÁS
			$igenyAdat = mysqli_fetch_row($resultIgeny);
			$dolgozAdat = mysqli_fetch_row($resultDolgozok);
			//$kolcsonzottAdat = mysqli_fetch_row($resultKolcsonzottDolgozok);
			// $kolcsonzottIgenyAdat = mysqli_fetch_row($resultKolcsonzottIgeny);

			//ADATOK KINYERÉSE
			$dolgozoMenny = (int) $dolgozAdat[0];
			$igenyMenny = (int) $igenyAdat[0] - $dolgozoMenny;
			//$kolcsonDolgozoMenny = (int) $kolcsonzottAdat[0];
			// $kolcsonIgenyMenny = (int) $kolcsonzottIgenyAdat[0] - $kolcsonDolgozoMenny;
			

			//Összegek
			$osszes = $dolgozoMenny + $igenyMenny;
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
							<div class="progress mx-auto" data-value='<?php echo ($dolgozoMenny/$osszes)*100; ?>'>
          						<span class="progress-left" data-toggle="tooltip" data-placement="top" title="Igény Mennyiség: <?php echo $igenyMenny; ?>">
                        			<span class="progress-bar" style="border-color:#2c3e50"></span>
          						</span>
          						<span class="progress-right" data-toggle="tooltip" data-placement="top" title="Dolgozó Mennyiség: <?php echo $dolgozoMenny; ?>">
                        			<span class="progress-bar" style="border-color:#2c3e50"></span>
          						</span>
          					<div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            					<div class="h5 font-weight-bold"><?php echo $osszes."/".$dolgozoMenny." fő"; ?></div>
          					</div>
        					</div>
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