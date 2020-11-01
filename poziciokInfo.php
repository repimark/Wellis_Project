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
			include 'contents/navbar.php';
			include 'connect.php';

	?>
	<div class="container p-5">
		<table class="table table-borderless table-sm text-center rounded">
			<?php
				$t_id = $_GET["id"];
				$pozicioSQL = "SELECT pozicio.p_elnevezes AS 'p_elnevezes', pozicio.p_id AS 'p_id' FROM pozicio WHERE pozicio.t_id = '$t_id'";
				$pozicioResult = $conn->query($pozicioSQL);

				while ($rowPozicio = $pozicioResult->fetch_assoc()) {
					$igenySQL  = "SELECT i_id, i_db, i_sajat FROM igeny WHERE p_id = '".$rowPozicio["p_id"]."'";
					$igenyResult = $conn->query($igenySQL); ?>
					<thead class="text-center table-dark bg-dark">
						<tr class="table-dark bg-dark rounded">
							<td colspan="3" class="bg-dark"><h2><?php echo $rowPozicio["p_elnevezes"]; ?></h2></td>
					<?php
						while ($rowIgeny = $igenyResult->fetch_assoc()) { 
							if ($rowIgeny["i_sajat"] == 0) { 
								$darabSQL = "SELECT COUNT(d_id) AS `db` FROM `dolgozok` WHERE a_id = 1 AND a_id = 3 AND p_id = ".$rowPozicio["p_id"]."";
								$sajatDolgozo = $conn->query($darabSQL);
								while ($rowDB = $sajatDolgozo->fetch_assoc()) {
									$veglegesSajat = (int)$rowIgeny["i_db"] - (int)$rowDB["db"];
								}
							
					?>

							<td colspan="1" class="bg-dark">
								<p style="margin:0">Saját igény: <?php echo $veglegesSajat;?></p>
								<button class="btn btn-secondary igenyPlus" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">+</button>
								<button class="btn btn-secondary igenyMinus" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">-</button>
							</td>

					<?php 
								}else{
									$darabSQL_2 = "SELECT COUNT(d_id) AS `db` FROM `dolgozok` WHERE a_id = 4 AND p_id = ".$rowPozicio["p_id"];
									$kolcsonzottDolgozo = $conn->query($darabSQL_2);
									while ($rowDB_2 = $kolcsonzottDolgozo->fetch_assoc()) {
										$veglegesKolcson = (int)$rowIgeny["i_db"] - (int)$rowDB_2["db"];
								}
					?>
						<td colspan="1" class="bg-dark">
								<p style="margin:0">Kölcsönzött igény: <?php echo $veglegesKolcson;
								?></p>
								<button class="btn btn-secondary igenyPlus" data-menny= "<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">+</button>
								<button class="btn btn-secondary igenyMinus" data-menny= "<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>">-</button>
							</td>
					<?php
							}	
								
						}
					?>

						</tr>
					</thead>
					<tbody class="table-dark rounded">
						<tr class="table-dark border-bottom bg-dark border-top-0">
							<td class="bg-dark">Név</td>
							<td class="bg-dark">Állapot</td>
							<td class="bg-dark">Műveletek</td>
							<td class="bg-dark" colspan="2">Megjegyzés</td>
						</tr>
						
				<?php
				$pid = $rowPozicio["p_id"];
				$dolgozoSQL = "SELECT dolgozok.d_id AS 'id', dolgozok.t_id AS 'ter_id', dolgozok.p_id AS 'pozi_id', dolgozok.d_nev AS 'nev', allapot.a_elnevezes AS 'allapot', dolgozok.a_id AS 'a_id', megjegyzes.m_szoveg AS 'Megjegyzes', megjegyzes.m_id AS 'm_id' FROM dolgozok, allapot, megjegyzes WHERE dolgozok.d_id = megjegyzes.d_id AND dolgozok.a_id = allapot.a_id AND megjegyzes.m_szoveg IS NOT NULL AND dolgozok.p_id = '".$pid."'";
				$dolgozoResult = $conn->query($dolgozoSQL);
				if ($dolgozoResult->num_rows > 0) {
				while ($rowDolgozo = $dolgozoResult->fetch_assoc()) {
					if ($rowDolgozo["a_id"] == 1) {
				?>	
					<tr class="table-success" style="">
					<td class="bg-dark text-success"><?php echo $rowDolgozo["nev"];  ?></td>
					<td class="bg-success"><?php echo $rowDolgozo["allapot"]; ?></td>
					
					<td colspan="" class="bg-success text-right">
						<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg>
            			</button>
						<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg>
						</button>
					</td>
					<td colspan="2" class="bg-success">
						<form class="form-inline">
						<input type="text" class="form-control" width="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes" id="<?php echo $rowDolgozo['m_id']; ?>" style="margin:2px">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
  								<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
							</svg>
						</button>
						</form>
						
					</td>
				</tr>
				
			<?php 	}elseif ($rowDolgozo["a_id"] == 2) { ?>
						<tr class="table-danger">
							<td class="bg-danger"><?php echo $rowDolgozo["nev"];  ?></td>
							<td><?php echo $rowDolgozo["allapot"]; ?></td>
							
							<td class="text-right">
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
								
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes" style="margin:2px">
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
						<tr class="table-info">
							<td><?php echo $rowDolgozo["nev"];  ?></td>
							<td><?php echo $rowDolgozo["allapot"]; ?></td>
							
							<td class="text-right">
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
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
					<tr class="table-success">
							<td><?php echo $rowDolgozo["nev"];  ?></td>
							<td><?php echo $rowDolgozo["allapot"]; ?></td>
							<td class="text-right">
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                				</svg>
                				</button>
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
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
					<tr class="table-warning">
							<td><?php echo $rowDolgozo["nev"];  ?></td>
							<td><?php echo $rowDolgozo["allapot"]; ?></td>
							<td class="text-right">
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                			</svg></button>
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev'];?>" data-id="<?php echo $rowDolgozo['id'];?>" data-terulet="<?php echo $rowDolgozo['ter_id'];?>" data-pozicio="<?php echo $rowDolgozo['pozi_id'];?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id'];?>">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  				<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                			</svg></button>
							</td>
							<td colspan="2">
						<form class="form-inline">
						<input type="text" class="form-control" width="" name="" id="<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
						<button type="button" class="btn btn-secondary addMegjegyzes" style="margin:2px">
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
					<td colspan="5" class="table-danger"><h5>Ehhez a pizicióhoz még nincs dolgozó.</h5></td>
				</tr>
				<?php
				}
				?>	
					<tr style="height: 40px"></tr>	
					</tbody>	
			<?php	
				}
			?>
		<!-- 
			
				
			</tbody> -->
		</table>

		<!-- FELUGRO ABLAK KEZDETE -->
	<div class="modal" tabindex="-1" id="editModal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="Modaltitle">Dolgozó szerkesztése</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
          <div class="form-group">
            <label for="dolgozo-nev" class="col-form-label">Név:</label>
            <input type="text" class="form-control" id="dolgozo-nev">
          </div>
          <div class="form-group">
            <label for="terulet-select" class="col-form-label">Terület</label><br>
             <select id="terulet_select"></select>
          </div>
          <div class="form-group">
            <label for="pozicio_select" class="col-form-label">Pozició</label><br>
            <select id="pozicio_select"></select>
          </div>
          <div class="form-group">
            <label for="allapot_select" class="col-form-label">Állapot</label><br>
            <select id="allapot_select"></select>
          </div>
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
	        <button type="button" id="update_button" class="btn btn-primary">Mentés</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal" tabindex="-1" id="deleteModal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="Modaltitle">Dolgozó Kiléptetése</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
          <div class="form-group">
            <label for="dolgozo-nev" class="col-form-label">Név:</label>
            <input type="text" class="form-control" id="dolgozo-nev">
          </div>
          <div class="form-group">
          	<label class="col-form-label" for="datum">Dátum</label>
          	<input type="text" name="datum" class="form-control" id="k_datum" placeholder="pl. 2020-01-01">
          </div>
          <div class="form-group">
          	<label for="kilepo">Szeretnéd a kiléptetett dolgozót igényként felvenni ?</label>
          	<input type="checkbox" name="kileptetes" value="kilep" id="kilepo">
          </div>
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
	        <button type="button" id="delete_button" class="btn btn-primary">Kiléptetés</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- FELUGRÓ ABLAK VÉGE -->
		<script type="text/javascript">
			$('.addMegjegyzes').click(function(){
				var id = $(this).attr('id');
				
				var szoveg = $("#"+id).val()
				//alert(id+' , '+szoveg)
				$.ajax({
					url: 'addNote.php',
					type: 'POST',
					cache: false,
					data: {
						m_id: id,
						m_text: szoveg
					},
					success: function(NotesResult){
						alert(NotesResult)
						location.reload()
					}
				});
			});
			$('.igenyPlus').click(function(){
				var mennyiseg = parseInt($(this).attr('data-menny'))
				var newMennyiseg = mennyiseg  + 1
				var id = $(this).attr('data-id')
				console.log(id + ' , '+newMennyiseg)
				//alert(id+' igényben '+(mennyiseg+1)+' darab lesz')
				$.ajax({
					url: 'updateIgeny.php',
					type: 'POST',
					cache: false,
					data: {
						i_id: id,
						menny: newMennyiseg
					},
					success: function(IgenyResult){
						//alert(IgenyResult)
						location.reload()
					}
				});
			});
			$('.igenyMinus').click(function(){
				var mennyiseg = parseInt($(this).attr('data-menny'))
				var newMennyiseg = 0
				if (mennyiseg > 0) {
					var newMennyiseg = mennyiseg  - 1
				}else{
					alert('nem mehetsz minuszba !')
					var newMennyiseg = mennyiseg
				}
				
				var id = $(this).attr('data-id')
				console.log(id + ' , '+newMennyiseg)
				//alert(id+' igényben '+(mennyiseg+1)+' darab lesz')
				$.ajax({
					url: 'updateIgeny.php',
					type: 'POST',
					cache: false,
					data: {
						i_id: id,
						menny: newMennyiseg
					},
					success: function(IgenyResult){
						//alert(IgenyResult)
						location.reload()
					}
				});
			});

			//FELUGRÓ ABLAKOK MEGJELEÍTŐ SCRIPTEK
			$('#deleteModal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var nev = button.data('whatever')
			var dolgozo_id = button.data('id')
			var pozicio_id = button.data('pozicio')
			var terulet_id = button.data('terulet')
			var allapot_id = button.data('allapot')
			var modal = $(this)
			modal.find('#Modaltitle').text(nev + " kiléptetése")
			modal.find('#dolgozo-nev').val(nev)
			modal.find('#k_datum').val()
			modal.find('#delete_button').attr('data-pozicio', pozicio_id)
			modal.find('#delete_button').attr('data-terulet', terulet_id)
			modal.find('#delete_button').attr('data-allapot', allapot_id)
			modal.find('#delete_button').attr('data-id',dolgozo_id)
			modal.find('#delete_button').attr('data-nev',nev)
		});
		$('#delete_button').click(function(){
			var button = $(this)
			var dolgozo_id = button.data('id')
			var pozicio_id = button.data('pozicio')
			var terulet_id = button.data('terulet')
			var allapot_id = button.data('allapot')
			var datum = $('#k_datum').val()
			var d_nev = button.data('nev')
			if ($('#kilepo').is(':checked')) {
				//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTELLEL
				alert(d_nev+' igényként kell felvenni id'+dolgozo_id+' pozi_id'+ pozicio_id+' terület_id '+terulet_id+' allapot_id'+allapot_id)
				$.ajax({
					url: 'kileptetes.php',
					type: 'POST',
					cache: false,
					data: {
						d_id: dolgozo_id,
						nev: d_nev,
						p_id: pozicio_id,
						t_id: terulet_id,
						a_id: allapot_id,
						datum: datum

					},
					success: function(KileptetesResult){
						console.log(KileptetesResult)
						location.reload()
					}
				});
			}else{
				//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTEL NÉLKÜL
				alert('nem kell igényként felvenni')
				$.ajax({
					url: 'kileptetes.php',
					type: 'POST',
					cache: false,
					data: {
						d_id:dolgozo_id,
						nev:d_nev,
						p_id:pozicio_id,
						t_id: terulet_id,
						a_id: allapot_id,
						datum: datum

					},
					success: function(KileptetesResult){
						//console.log(KileptetesResult)
					}
				});
				if (allapot_id ==  4) {
					var kolcsonzott = 1
					$.ajax({
						url: 'igenyRendezes.php',
						type: 'POST',
						cache: false,
						data: {
							i_sajat: kolcsonzott,
							p_id: pozicio_id
						},
						success: function(igenyRendezesResult){
							console.log(igenyRendezesResult)
							location.reload()
						}
					});
				}else{
					var kolcsonzott = 0
					$.ajax({
						url: 'igenyRendezes.php',
						type: 'POST',
						cache: false,
						data: {
							i_sajat: kolcsonzott,
							p_id: pozicio_id
						},
						success: function(igenyRendezesResult){
							console.log(igenyRendezesResult)
							location.reload()

						}
					});
				}
			}

		});

  		$('#editModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var d_nev = button.data('id')
		  $(this).attr('data-id',d_nev)
		  // var d_terulet = button.data('terulet')//$('#d_ter').text()
		  // var d_allapot = button.data('allapot')//$('#d_allapot').text()
		  // var d_pozicio = button.data('pozicio')//$('#d_pozi').text()
		  var nev = button.data('whatever') // Extract info from data-* attributes
		  // var allapot_id = button.data('id')
		  console.log(nev)
		  var pozicio_id = button.data('pozicio')
		  console.log(pozicio_id)
		  var terulet_id = button.data('terulet')
		  console.log(terulet_id)
		  var allapot_id = button.data('allapot')
		  console.log(allapot_id)
		  var dolgozo_id = button.data('id')
		  console.log(dolgozo_id)
		  var modal = $(this)
		  modal.find('#Modaltitle').text(nev + " szerkesztése")
		  modal.find('#dolgozo-nev').val(nev)
		  
		  //Terület lekérdezése
		  $.ajax({
		  	url: "getUserTerulet.php",
		  	type: "POST",
		  	cache: false,
		  	data:{
		  		t_id: terulet_id
		  	},
		  	success: function(dataResult_terulet){
		  		$('#terulet_select').html(dataResult_terulet);
		  	}
		  });
		  //Pozicíó lekérdezése
		  $.ajax({
		  	url: "getPozicioForUserAdd.php",
		  	type: "POST",
		  	cache: false,
		  	data:{
		  		t_id: terulet_id,
		  		p_id: pozicio_id
		  	},
		  	success: function(dataResult_pozi){
		  		console.log(dataResult_pozi)
		  		$('#pozicio_select').html(dataResult_pozi);
		  	}
		  });
		  //Állapot lekérdezése
		  $.ajax({
			url: "getAllapot.php",
			type: "POST",
			cache: false,
			data:{
				a_id: allapot_id
			},
			success: function(dataResult_allapot){
				$('#allapot_select').html(dataResult_allapot);
			}
			});
		})
		$('#update_button').click(function(){
			var dolgozo_id = $("#editModal").data('id')
			var terulet_id = $("#terulet_select option:selected").data('id')
			var pozicio_id = $("#pozicio_select option:selected").data('id')
			var allapot_id = $("#allapot_select option:selected").data('id')
			var dolgozo_nev = $("#dolgozo-nev").val()
			console.log(dolgozo_nev)
			$.ajax({
				url: "updateUser.php",
				type: "POST",
				cache: false,
				data:{
					d_id: dolgozo_id,
					p_id: pozicio_id,
					t_id: terulet_id,
					a_id: allapot_id,
					d_nev: dolgozo_nev
				},
				success: function(updateDataResult){
					console.log(updateDataResult);
					//alert("update success");
					location.reload();

				}
			});
			
		});
		$('#terulet_select').change(function(){
			//alert('változott')
			var t_id =  $('#terulet_select option:selected').data('id')
			var pozi_select = $('#pozicio_select')
			//console.log(t_id)
			$.ajax({
				url: "getPozicioForUserAdd.php",
				type: "POST",
				cache: false,
				data:{
					t_id: t_id
				},
				success: function(getPozicioResult){
					console.log(getPozicioResult);
					//alert("update success");
					$('#pozicio_select').html(getPozicioResult);

				}
			});
		});
		</script>
	</div>
</body>
</html>