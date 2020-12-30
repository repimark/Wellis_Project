<table class="table table-borderless table-sm text-center rounded">
			<?php
				$sor = $sorokROW["s_id"];
				$pozicioSQL = "SELECT pozicio.p_elnevezes AS 'p_elnevezes', pozicio.p_id AS 'p_id' FROM pozicio, k_terulet WHERE k_terulet.s_id = $sor AND k_terulet.p_id = pozicio.p_id AND pozicio.t_id = '$t_id' ORDER BY p_id ASC";
				$pozicioResult = $conn->query($pozicioSQL);

				while ($rowPozicio = $pozicioResult->fetch_assoc()) {
					$igenySQL  = "SELECT i_id, i_db, i_sajat FROM igeny WHERE p_id = '".$rowPozicio["p_id"]."'";
					$igenyResult = $conn->query($igenySQL); ?>
					<thead class="text-center table-dark bg-dark">
						<tr class="table-dark bg-dark rounded">
							<td colspan="4" class="bg-dark"><p><?php echo ($rowPozicio["p_elnevezes"]); ?></p></td>
					<?php
						while ($rowIgeny = $igenyResult->fetch_assoc()) { 
							if ($rowIgeny["i_sajat"] == '0') { 
								$darabSQL = "SELECT COUNT(d_id) AS `db` FROM `dolgozok` WHERE p_id = '".$rowPozicio["p_id"]."' AND a_id = 1 OR p_id = '".$rowPozicio["p_id"]."' AND a_id = 3 OR p_id = '".$rowPozicio["p_id"]."' AND a_id = 4";
								$sajatDolgozo = $conn->query($darabSQL);
								while ($rowDB = $sajatDolgozo->fetch_assoc()) {
									$veglegesSajat = (int)$rowIgeny["i_db"] - (int)$rowDB["db"];
								}
							
					?>

							<td colspan="1" class="bg-dark">
								<p style="margin:0">Saját igény: <?php echo $veglegesSajat;?></p>
								<button class="btn btn-secondary igenyPlus gomb" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">+</button>
								<button class="btn btn-secondary igenyMinus gomb" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">-</button>
							</td>

					<?php 
								}else{
									$darabSQL_2 = "SELECT COUNT(d_id) AS `db` FROM `dolgozok` WHERE a_id = 4 AND p_id = ".$rowPozicio["p_id"];
									$kolcsonzottDolgozo = $conn->query($darabSQL_2);
									while ($rowDB_2 = $kolcsonzottDolgozo->fetch_assoc()) {
										$veglegesKolcson = (int)$rowIgeny["i_db"] - (int)$rowDB_2["db"];
								}
					?>
						<td colspan="2" class="bg-dark">
								<p style="margin:0">Kölcsönzött igény: <?php echo $veglegesKolcson;
								?></p>
								<button class="btn btn-secondary igenyPlus gomb" data-menny= "<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">+</button>
								<button class="btn btn-secondary igenyMinus gomb" data-menny= "<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">-</button>
							</td>
					<?php
							}	
								
						}
					?>

						</tr>
					</thead>
					<tbody class="table-dark rounded">
						<tr class="table-dark border-bottom bg-dark border-top-0">
							<td class="bg-dark"></td>
							<td class="bg-dark">Név</td>
							<td class="bg-dark">Állapot</td>
							<td class="bg-dark">Műveletek</td>
							<td class="bg-dark" colspan="2">Megjegyzés</td>
						</tr>
						
						
				<?php
				$pid = $rowPozicio["p_id"];
				$dolgozoSQL = "SELECT dolgozok.d_id AS 'id', dolgozok.t_id AS 'ter_id', dolgozok.p_id AS 'pozi_id', dolgozok.d_nev AS 'nev', allapot.a_elnevezes AS 'allapot', dolgozok.a_id AS 'a_id', megjegyzes.m_szoveg AS 'Megjegyzes', megjegyzes.m_id AS 'm_id', dolgozok.b_datum as 'belepes' FROM dolgozok, allapot, megjegyzes WHERE dolgozok.d_id = megjegyzes.d_id AND dolgozok.a_id = allapot.a_id AND megjegyzes.m_szoveg IS NOT NULL AND dolgozok.p_id = '".$pid."'";
				$dolgozoResult = $conn->query($dolgozoSQL);
				if ($dolgozoResult->num_rows > 0) {
				while ($rowDolgozo = $dolgozoResult->fetch_assoc()) {
					if ($rowDolgozo["a_id"] == 1) {
				?>	
					<tr class="" style="">
						<td class="colorScheme" style="background-color:#33CC00!important;width: 1px!important;border:1px solid #343a40;"></td>	
						<td class="" style=""><?php echo $rowDolgozo["nev"];  ?></td>
						<td class="dolgozo"><?php echo $rowDolgozo["allapot"]; ?></td>
						<td colspan="" class=" text-right">
							<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

	                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
	                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
	                			</svg>
	            			</button>
							<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
	                			</svg>
							</button>
						</td>
						<td colspan="2" class="">
							<form class="form-inline">
							<input type="text" class="form-control" width="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
							<button type="button" class="btn btn-secondary addMegjegyzes gomb" id="<?php echo $rowDolgozo['m_id']; ?>" style="margin:2px">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
	  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
	  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
								</svg>
							</button>
							</form>
							
						</td>
				</tr>
				
			<?php 	}elseif ($rowDolgozo["a_id"] == 6) { ?>
						<tr class="">
							<td class="colorScheme" style="background-color:#FFB900!important;width: 1px!important;border:1px solid #343a40;"></td>
							<td class=""><?php echo $rowDolgozo["nev"];  ?><br>(<?php echo $rowDolgozo["belepes"]; ?>)</td>
							<td class="belepo"><?php echo $rowDolgozo["allapot"]; ?></td>
							
							<td class="text-right">
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
								
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
							</svg>
						</button>
						</form>
						
					</td>
						</tr>
				<?php	}elseif ($rowDolgozo["a_id"] == 3) { ?>
						<tr class="">
							<td class="colorScheme" style="background-color:#CC0000!important;width: 1px!important;border:1px solid #343a40;"></td>
							<td><?php echo $rowDolgozo["nev"];  ?></td>
							<td class="tartosbeteg"><?php echo $rowDolgozo["allapot"]; ?></td>
							
							<td class="text-right">
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
							</svg>
						</button>
						</form>
						
					</td>
						</tr>
				<?php }elseif ($rowDolgozo["a_id"] == 4) { ?>
					<tr class="">
						<td class="colorScheme" style="background-color:#CC0000!important;width: 1px!important;border:1px solid #343a40;"></td>
							<td><?php echo $rowDolgozo["nev"];  ?></td>
							<td class="kolcsonzott"><?php echo $rowDolgozo["allapot"]; ?></td>
							<td class="text-right">
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                				</svg>
                				</button>
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
							</svg>
						</button>
						</form>
						
					</td>
						</tr>
				<?php }else{ ?>
					<tr class="">
							<td class="colorScheme" style="background-color:#FFB300!important;width: 1px!important;border:1px solid #343a40;"></td>
							<td><?php echo $rowDolgozo["nev"];  ?><br>(<?php echo $rowDolgozo["belepes"]; ?>)</td>
							<td class="belepo"><?php echo $rowDolgozo["allapot"]; ?></td>
							<td class="text-right">
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
							</svg>
						</button>
						</form>
						
					</td>
						</tr>
				<?php }	
					}	
				}else{ 
				?>
				<tr>
					<td colspan="6" class="table-danger"><h5>Ehhez a pozicióhoz még nincs dolgozó.</h5></td>
				</tr>
				<?php
				}
				?>	
					<tr style="height: 40px"></tr>	
					</tbody>	
			<?php	
				}
			?>
		</table>