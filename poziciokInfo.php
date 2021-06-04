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
		<!-- <meta http-equiv="refresh" content="10"> -->
		<style type="text/css">
			.form-control {
				font-size: 13px;
			}

			.igenyPlus {
				width: 2rem;
				height: 2rem;
				text-align: center;

			}

			.igenyMinus {
				width: 2rem;
				height: 2rem;
				text-align: center;

			}

			.bg-dark {
				font-size: 1rem;
			}

			.bg-success {
				font-size: 1rem;
				background-color: #69797e !important;
			}

			.table-success {
				/*background-color: #69797e!important;*/
			}

			.bg-dark {
				/*background-color: #69797e!important;	*/
			}

			.dolgozo {
				color: #33CC00 !important;
				/*color:#3aaf85!important;*/
			}

			.kolcsonzott {
				color: #ad62aa !important;
				/*color:#b57170!important;*/
			}

			.belepo {
				color: #FFB300 !important;
				/*color: #FFB900!important;*/
			}

			.tartosbeteg {
				color: #66bfbf !important;
			}

			.btn-secondary {
				background-color: #69797e !important;
			}

			.form-control {
				height: 30px !important;
			}

			.gomb {
				height: 30px !important;
				width: 30px !important;
				padding: 0px !important;
			}

			.gomb svg {
				top: 0px !important;
				left: 0px !important;
			}

			tbody tr {
				height: 30px !important;
			}

			.btn:hover {
				border: 1px solid white;
			}
			.elkuldes {
				color: #F85959 !important;
			}
			.problemas {
				color: #FF0000 !important;
			}
		</style>
	</head>

	<body>
		<?php
		//Ide kérjük be a fejlécet a menüt és az adatbázis kapcsolatot nyitjuk meg 
		if ($_SESSION["jog"] == "1") {
			require('contents/navbar.php');
		} else if ($_SESSION["jog"] == "2") {
			require('contents/userNavbar.php');
		}
		require('connect.php');
		?>
		<div class="container p-5">
			<?php $t_id = $conn->escape_string($_GET["id"]); ?>
			<h5><button class="btn btn-success" id="export" data-terulet="<?php echo $t_id; ?>"><img src="excel.png" height="20"> Exportálás Excelbe</button></h5>
			<div class="row bg-dark text-white text-middle rounded w-50 m-1">

				<h4 class="p-1 text-center" id="addDolgozo" data-toggle="modal" data-target="#addModal"><span class="badge-success badge">+</span> Új dolgozó hozzáadása</h4>
			</div>
			<?php
			if ($t_id == "7") {
				include 'php/getSorok.php';
			?>

			<?php
			} else {
			?>
				<table class="table table-borderless table-sm text-center rounded">
					<?php

					$pozicioSQL = "SELECT pozicio.p_elnevezes AS 'p_elnevezes', pozicio.p_id AS 'p_id' FROM pozicio WHERE pozicio.t_id = '$t_id'";
					$pozicioResult = $conn->query($pozicioSQL);

					while ($rowPozicio = $pozicioResult->fetch_assoc()) {
						$letszam = 0;
						$igenySQL  = "SELECT i_id, i_db, i_sajat FROM igeny WHERE p_id = '" . $rowPozicio["p_id"] . "'";
						$igenyResult = $conn->query($igenySQL); ?>
						<thead class="text-center table-dark bg-dark">
							<tr class="table-dark bg-dark rounded">
								<td colspan="4" class="bg-dark">
									<p><?php echo ($rowPozicio["p_elnevezes"]); ?></p>
								</td>
								<?php
								while ($rowIgeny = $igenyResult->fetch_assoc()) {
									$darabSQL = "SELECT COUNT(d_id) AS `db` FROM `dolgozok` WHERE p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 1 OR p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 3 OR p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 4 OR p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 5 OR p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 6 OR p_id = '" . $rowPozicio["p_id"] . "' AND a_id = 7 OR p_id = '".$rowPozicio['p_id']."' AND a_id = 8";
									
									$sajatDolgozo = $conn->query($darabSQL);
									while ($rowDB = $sajatDolgozo->fetch_assoc()) {
										$veglegesSajat = ((int)$rowIgeny["i_db"] - (int)$rowDB["db"]);
										$letszam = (int)$rowDB["db"];
									}

								?>
									
									<td colspan="1" class="bg-dark">
										<p style="margin:0">Saját igény: <?php echo $veglegesSajat; ?></p>
										<button class="btn btn-secondary igenyPlus gomb" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>" data-pozi="<?php echo $rowPozicio['p_id']; ?>">+</button>
										<button class="btn btn-secondary igenyMinus gomb" data-menny="<?php echo $rowIgeny['i_db']; ?>" data-id="<?php echo $rowIgeny['i_id']; ?>" data-pozi="<?php echo $rowPozicio['p_id']; ?>">-</button>
										<br/>
										<span class="badge badge-info">Létszám : <?php echo $letszam;?> Fő</span>
									</td>

								<?php

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
							$dolgozoSQL = "SELECT dolgozok.d_id AS 'id', dolgozok.t_id AS 'ter_id', dolgozok.p_id AS 'pozi_id', dolgozok.d_nev AS 'nev', allapot.a_elnevezes AS 'allapot', dolgozok.a_id AS 'a_id', megjegyzes.m_szoveg AS 'Megjegyzes', megjegyzes.m_id AS 'm_id', dolgozok.b_datum AS 'belepes' FROM dolgozok, allapot, megjegyzes WHERE dolgozok.d_id = megjegyzes.d_id AND dolgozok.a_id = allapot.a_id AND megjegyzes.m_szoveg IS NOT NULL AND dolgozok.p_id = '" . $pid . "'";
							$dolgozoResult = $conn->query($dolgozoSQL);
							if ($dolgozoResult->num_rows > 0) {
								while ($rowDolgozo = $dolgozoResult->fetch_assoc()) {
									if ($rowDolgozo["a_id"] == 1) {
							?>
										<tr class="" style="">
											<td class="colorScheme" style="background-color:#33CC00!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td class="" style=""><?php echo $rowDolgozo["nev"];  ?></td>
											<td class="dolgozo"><?php echo $rowDolgozo["allapot"]; ?></td>
											<td colspan="" class=" text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg>
												</button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo '0' . $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg>
												</button>
											</td>
											<td colspan="2" class="">
												<form class="form-inline">
													<input type="text" class="form-control" width="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" id="<?php echo $rowDolgozo['m_id']; ?>" style="margin:2px">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>

									<?php 	} elseif ($rowDolgozo["a_id"] == 7) { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#F85959!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td class=""><?php echo $rowDolgozo["nev"];  ?></td>
											<td class="elkuldes"><?php echo $rowDolgozo["allapot"]; ?></td>

											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg></button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>

											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
										<?php 	} elseif ($rowDolgozo["a_id"] == 6) { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#FFB900!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td class=""><?php echo $rowDolgozo["nev"];  ?><br>(<?php echo $rowDolgozo["belepes"]; ?>)</td>
											<td class="belepo"><?php echo $rowDolgozo["allapot"]; ?></td>

											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg></button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>

											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
										<?php 	} elseif ($rowDolgozo["a_id"] == 8) { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#FF0000!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td class=""><?php echo $rowDolgozo["nev"];  ?></td>
											<td class="problemas"><?php echo $rowDolgozo["allapot"]; ?></td>

											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg></button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>

											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
									<?php	} elseif ($rowDolgozo["a_id"] == 3) { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#66bfbf!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td><?php echo $rowDolgozo["nev"];  ?></td>
											<td class="tartosbeteg"><?php echo $rowDolgozo["allapot"]; ?></td>

											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg></button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>
											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
									<?php } elseif ($rowDolgozo["a_id"] == 4) { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#ad62aa!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td><?php echo $rowDolgozo["nev"];  ?></td>
											<td class="kolcsonzott"><?php echo $rowDolgozo["allapot"]; ?></td>
											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg>
												</button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>
											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
									<?php } else { ?>
										<tr class="">
											<td class="colorScheme" style="background-color:#FFB300!important;width: 1px!important;border:1px solid #343a40;"></td>
											<td><?php echo $rowDolgozo["nev"];  ?><br>(<?php echo $rowDolgozo["belepes"]; ?>)</td>
											<td class="belepo"><?php echo $rowDolgozo["allapot"]; ?></td>
											<td class="text-right">
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#editModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg></button>
												<button type="button" class="btn btn-secondary gomb" data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo $rowDolgozo['nev']; ?>" data-id="<?php echo $rowDolgozo['id']; ?>" data-terulet="<?php echo $rowDolgozo['ter_id']; ?>" data-pozicio="<?php echo $rowDolgozo['pozi_id']; ?>" data-allapot="<?php echo $rowDolgozo['a_id']; ?>" data-id="<?php echo $rowPozicio['p_id']; ?>" data-belepes="<?php echo $rowDolgozo['belepes']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
													</svg></button>
											</td>
											<td colspan="2">
												<form class="form-inline">
													<input type="text" class="form-control" width="" name="" id="m<?php echo $rowDolgozo['m_id']; ?>" value="<?php echo $rowDolgozo['Megjegyzes']; ?>">
													<button type="button" class="btn btn-secondary addMegjegyzes gomb" style="margin:2px" id="<?php echo $rowDolgozo['m_id']; ?>">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-journal-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
															<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
															<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
														</svg>
													</button>
												</form>

											</td>
										</tr>
								<?php }
								}
							} else {
								?>
								<tr>
									<td colspan="6" class="table-danger">
										<h5>Ehhez a pozicióhoz még nincs dolgozó.</h5>
									</td>
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
			<?php } ?>
			<!-- SZERKESZTÉS -->
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
									<label for="edit_dolgozo-nev" class="col-form-label">Név:</label>
									<input type="text" class="form-control" id="edit_dolgozo-nev">
								</div>
								<div class="form-group">
									<label for="#edit_terulet-select" class="col-form-label">Terület</label><br>
									<select id="edit_terulet_select" class="form-control"></select>
								</div>
								<div class="form-group" id="edit_sorSel">
									<label for="#edit_sor-select" class="col-form-label">Sorok</label><br>
									<select id="edit_sor_select" class="form-control"></select>
								</div>
								<div class="form-group">
									<label for="#edit_pozicio_select" class="col-form-label">Pozició</label><br>
									<select id="edit_pozicio_select" class="form-control"></select>
								</div>
								<div class="form-group">
									<label for="#edit_allapot_select" class="col-form-label">Állapot</label><br>
									<select id="edit_allapot_select" class="form-control"></select>
								</div>
								<div class="form-group">
									<label for="#edit_belepes" class="col-form-label">Belépési dátum</label><br>
									<input id="edit_belepes" class="form-control" />
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
			<!-- KILÉPTETÉS -->
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
									<label for="#delete_dolgozo-nev" class="col-form-label">Név:</label>
									<input type="text" class="form-control" id="delete_dolgozo-nev">
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
							<button type="button" class="btn btn-danger" id="remove_button">X</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
							<button type="button" id="delete_button" class="btn btn-primary">Kiléptetés</button>
						</div>
					</div>
				</div>
			</div>
			<!-- ÚJ DOLGOZÓ HOZZÁADÁSA -->
			<div class="modal" tabindex="-1" id="addModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="Modaltitle">Dolgozó hozzáadása</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form class="">
								<div class="form-group">
									<label for="#add_dolgozoNev">Név</label>
									<input type="text" class="form-control" id="add_dolgozoNev" placeholder="Teljes Név" required autofocus>
								</div>
								<div class="form-group">
									<label for="#add_teruletSelect">Terület</label>
									<select class="form-control" id="add_teruletSelect" required>
										<?php
										$result = $conn->query("SELECT terulet.t_elnevezes AS terulet, t_id FROM terulet");
										while ($row = $result->fetch_assoc()) {
											echo "<option data-id=" . $row["t_id"] . ">" . $row["terulet"] . "</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group" id="add_sorSel">
									<label for="#add_sorSelect">Sor</label>
									<select class="form-control" id="add_sorSelect"></select>
								</div>
								<div class="form-group">
									<label for="#add_pozicioSelect">Pozíció</label>
									<select class="form-control" id="add_pozicioSelect" required>
										<!-- PHP BETÖLTI AZ TERÜLET ALAPJÁN A POZICÍÓKAT -->
									</select>
								</div>
								<div class="form-group">
									<label for="#add_allapotSelect">Állapot</label>
									<select class="form-control" id="add_allapotSelect" required>
										<?php
										$result = $conn->query("SELECT a_id, a_elnevezes  FROM allapot");
										while ($row = $result->fetch_assoc()) {
											echo "<option data-id=" . $row["a_id"] . ">" . $row["a_elnevezes"] . "</option>";
										}
										?>
									</select>
								</div>
								<div id="kolcsonzo" class="">
									<div class="form-group">
										<label for="#kolcsonzoCeg">Kölcsönző cég</label>
										<select id="kolcsonzoCeg" class="form-control">
											<option></option>
											<option value="WHC">WHC</option>
											<option value="TW">Trenkwalder</option>
											<option value="Mcom">Melicom</option>
											<option value="MunkaL">Munkaland</option>
											<option value="GW">Getwork</option>
										</select>
									</div>
								</div>
								<div id="belepes" class="">
									<div class="form-group">
										<label for="#belepesIdo">Belépési idő</label>
										<input type="text" id="belepesIdo" class="form-control">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
							<button type="button" id="add_button" class="btn btn-primary">Hozzáadás</button>
						</div>
					</div>
				</div>
			</div>
			<!-- FELUGRÓ ABLAK VÉGE -->
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				udpateHiddenStats()
				userKezeles()

			});
			var userKezeles = function() {
				var jogosultsag = '<?php echo $_SESSION["jog"]; ?>'
				//alert(jogosultsag)
				if (jogosultsag == '2') {
					$('.btn').attr('disabled', true)
					$('.btn-block').attr('disabled', false)
					$('#addDolgozo').attr('disabled', true)
					$('#export').attr('disabled', false)
					$('.addMegjegyzes').attr('disabled', false)
					//$('.accordion').collapse('toggle')
				}
			}
			var sorokKezelese = function(ter, sor) {
				//console.log(ter)
				var terulet = $(ter).data('id')
				//console.log(terulet)
				if (terulet == 7) {
					$('#edit_sorSel').show()
					$('#add_sorSel').show()
					$.ajax({
						url: 'php/getSor.php',
						type: 'POST',
						cache: false,
						success: function(SorResult) {
							var obj = JSON.parse(SorResult);
							var lines = [];
							if (obj.length > 0) {
								////console.log('nagyobb a cucli')
								for (var i = obj.length - 1; i >= 0; i--) {
									lines += '<option class="" data-id="' + obj[i].id + '">' + obj[i].elnev + '</option>'
								}
							} else {
								lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
							}
							//console.log(lines)
							//console.log(sor)
							$(sor).html(lines)
						},
						error: function(error) {
							//console.log(error)
						}
					});
				} else {
					$('#edit_sorSel').hide()
				}
			}

			$('.addMegjegyzes').click(function() {
				var id = $(this).attr('id');
				var userName = '<?php echo $_SESSION["u_name"]; ?>';
				var fName = userName.slice(0, 1).toUpperCase()
				var secName = userName.split('.')
				var secsec = secName[1]
				var secName = secsec.slice(0, 1).toUpperCase()
				userName = fName + '' + secName
				var szoveg = $('#m' + id).val()
				if (szoveg == '' || szoveg == '-') {

				} else {
					szoveg = szoveg + ' -' + userName
				}
				//alert(id+' , '+szoveg)
				$.ajax({
					url: 'addNote.php',
					type: 'POST',
					cache: false,
					data: {
						m_id: id,
						m_text: szoveg
					},
					success: function(NotesResult) {
						//alert(NotesResult)
						location.reload()
					},
					error: function(error) {
						console.log(error)
					}
				});
			});
			var igenyLog = function(pozi, muvelet) {
				var pozicio = pozi
				var muv = muvelet
				var d = new Date()
				var datum = d.getFullYear() + '.' + (d.getMonth() + 1) + '.' + d.getDate()
				var user = '<?php echo $_SESSION["u_name"]; ?>'
				////console.log('pozicio id = '+pozicio+' művelet : '+muv+' dátum : '+datum+' és az aki az egészet csinálta az egy csíra '+user)
				$.ajax({
					url: 'php/igenyLog.php',
					type: 'POST',
					cache: false,
					data: {
						muv: muv,
						u_name: user,
						datum: datum,
						pid: pozicio
					},
					success: function(res) {
						location.reload()
					},
					error: function(error) {
						//console.log(error)
					}
				});
			};
			$('.igenyPlus').click(function() {
				var mennyiseg = parseInt($(this).attr('data-menny'))
				var newMennyiseg = mennyiseg + 1
				var id = $(this).attr('data-id')
				var pozi = $(this).attr('data-pozi')
				//console.log(id + ' , ' + newMennyiseg)
				//alert(id+' igényben '+(mennyiseg+1)+' darab lesz')
				$.ajax({
					url: 'updateIgeny.php',
					type: 'POST',
					cache: false,
					data: {
						i_id: id,
						menny: newMennyiseg
					},
					success: function(IgenyResult) {
						//alert(IgenyResult)
						igenyLog(pozi, '+')
						location.reload()
					},
					error: function(error) {
						console.log(error)
					}
				});
			});
			$('.igenyMinus').click(function() {
				var mennyiseg = parseInt($(this).attr('data-menny'))
				var newMennyiseg = 0
				var newMennyiseg = mennyiseg - 1
				var id = $(this).attr('data-id')
				var pozi = $(this).attr('data-pozi')
				//console.log(id + ' , ' + newMennyiseg)
				//alert(id+' igényben '+(mennyiseg+1)+' darab lesz')
				$.ajax({
					url: 'updateIgeny.php',
					type: 'POST',
					cache: false,
					data: {
						i_id: id,
						menny: newMennyiseg
					},
					success: function(IgenyResult) {
						igenyLog(pozi, '-')
						location.reload()
					},
					error: function(error) {
						console.log(error)
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
				var b_datum = button.data('belepes')
				var modal = $(this)
				modal.find('#Modaltitle').text(nev + " kiléptetése")
				modal.find('#delete_dolgozo-nev').val(nev)
				var d = new Date();
				modal.find('#k_datum').val(d.getFullYear() + '.' + (d.getMonth() + 1) + '.' + d.getDate())
				modal.find('#delete_button').attr('data-pozicio', pozicio_id)
				modal.find('#delete_button').attr('data-terulet', terulet_id)
				modal.find('#delete_button').attr('data-allapot', allapot_id)
				modal.find('#delete_button').attr('data-id', dolgozo_id)
				modal.find('#delete_button').attr('data-nev', nev)
				modal.find('#delete_button').attr('data-belepes', b_datum)
				modal.find('#remove_button').attr('data-id', dolgozo_id)
				modal.find('#remove_button').attr('data-pozicio', pozicio_id)
			});
			$('#delete_button').click(function() {
				var button = $(this)
				var dolgozo_id = button.data('id')
				var pozicio_id = button.data('pozicio')
				var terulet_id = button.data('terulet')
				var allapot_id = button.data('allapot')
				var b_datum = button.data('belepes')
				var datum = $('#k_datum').val()
				var d_nev = button.data('nev')
				if ($('#kilepo').is(':checked')) {
					//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTELLEL
					//alert(d_nev+' igényként kell felvenni id'+dolgozo_id+' pozi_id'+ pozicio_id+' terület_id '+terulet_id+' allapot_id'+allapot_id)
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
							datum: datum,
							belepes: b_datum

						},
						success: function(KileptetesResult) {
							alert(KileptetesResult)
							location.reload()
						},
						error: function(error) {
							//console.log(error)
						}
					});
				} else {
					//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTEL NÉLKÜL
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
							datum: datum,
							belepes: b_datum

						},
						success: function(KileptetesResult) {
							location.reload()
						},
						error: function(error) {
							//console.log(error)
						}
					});
					var kolcsonzott = 0
					$.ajax({
						url: 'igenyRendezes.php',
						type: 'POST',
						cache: false,
						data: {
							i_sajat: kolcsonzott,
							p_id: pozicio_id
						},
						success: function(igenyRendezesResult) {
							//console.log(igenyRendezesResult)
							//location.reload()

						}
					});
				}

			});
			$('#remove_button').click(function() {
				var button = $(this)
				var dolgozo_id = button.data('id')
				var pozicio_id = button.data('pozicio')
				if ($('#kilepo').is(':checked')) {

					$.ajax({
						url: 'php/belepesVisszavonas.php',
						type: 'POST',
						data: {
							d_id: dolgozo_id
						},
						success: function(res) {
							console.log(res)
							location.reload()
						},
						error: function(errorRes) {
							console.log(errorRes)
						}
					});
					
				} else {
					$.ajax({
						url: 'php/belepesVisszavonas.php',
						type: 'POST',
						data: {
							d_id: dolgozo_id
						},
						success: function(res) {
							console.log(res)
							location.reload()
						},
						error: function(errorRes) {
							console.log(errorRes)
						}
					});
					$.ajax({
						url: 'igenyRendezes.php',
						type: 'POST',
						cache: false,
						data: {
							i_sajat: 0,
							p_id: pozicio_id
						},
						success: function(res) {
							
						},
						error: function(errorRes){
							alert(errorRes)
						}
					});
				}
			});
			$('#addDolgozo').click(function() {});
			$('#addModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget)
				updatePozicio()
				var modal = $(this)
				var t_id = $('#add_terulet_Select :selected').data('id')
				if (t_id == 7) {
					$('#add_sorSel').show()
				} else {
					$('#add_sorSel').hide()
				}

			});

			var udpateHiddenStats = function() {
				$('#kolcsonzo').hide()
				$('#belepes').hide()
			}
			$('#add_teruletSelect').change(function() {
				updatePozicio()
				sorokKezelese('#add_teruletSelect :selected', '#add_sorSelect')
			});

			$('#add_sorSelect').change(function() {
				var sor = $('#add_sorSelect :selected').data('id')
				getpoziciofromsor('#add_pozicioSelect', sor)
			});
			$('#edit_sor_select').change(function() {
				var sor = $('#edit_sor_select :selected').data('id')
				getpoziciofromsor('#edit_pozicio_select', sor)
			});
			var getpoziciofromsor = function(pozi, sor) {

				$.ajax({
					url: 'php/getPoziFromSor.php',
					type: 'POST',
					chache: false,
					data: {
						s_id: sor
					},
					success: function(RESULT) {
						var obj = JSON.parse(RESULT);
						var lines = [];
						if (obj.length > 0) {
							////console.log('nagyobb a cucli')
							for (var i = obj.length - 1; i >= 0; i--) {
								lines += '<option class="" data-id="' + obj[i].p_id + '">' + obj[i].p_elnevezes + '</option>'
							}
						} else {
							lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
						}
						////console.log(lines)
						$(pozi).html(lines)
					},
					error: function(error) {
						//console.log(error)
					}
				});

			}
			var updatePozicio = function() {
				var terulet_id = $("#add_teruletSelect option:selected").data('id')
				var sid = $('#add_sorSelect option:selected').data('id')
				////console.log(terulet_id)
				if (terulet_id == 7) {
					$('#add_sorSel').show()
					sorokKezelese('#add_teruletSelect :selected', '#add_sorSelect')
					$('#add_pozicioSelect').html('')
					//console.log('belépett ebbe a szaros szarba')
					$.ajax({
						url: "php/getSorok_2.php",
						type: "POST",
						cache: false,
						data: {
							t_id: terulet_id,
							sor: sid
						},
						success: function(getPozicioResult) {
							////console.log(getPozicioResult)
							var obj = JSON.parse(getPozicioResult);
							var lines = [];
							if (obj.length > 0) {
								//console.log('nagyobb a cucli')
								for (var i = obj.length - 1; i >= 0; i--) {
									lines += '<option class="" data-id="' + obj[i].p_id + '">' + obj[i].p_elnevezes + ' | ' + obj[i].s_elnevezes + '</option>'
								}
							} else {
								lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
							}
							//console.log(lines)
							$('#add_pozicioSelect').html(lines)



						},
						error: function(error) {
							//console.log(error)
						}
					});
				} else {
					$('#add_sorSel').hide()
					$.ajax({
						url: "getPozicioForUserAdd.php",
						type: "POST",
						cache: false,
						data: {
							t_id: terulet_id
						},
						success: function(getPozicioResult) {
							//console.log(getPozicioResult);
							//alert("update success");
							$('#add_pozicioSelect').html(getPozicioResult);
						},
						error: function(error) {
							//console.log(error)
						}
					});
				}
			};
			$('#add_allapotSelect').change(function() {
				kolcsonzottCeg()
			});
			var kolcsonzottCeg = function() {
				if ($('#add_allapotSelect option:selected').data('id') == '4') {
					//alert('Kölcsönzött dolgozó')
					$('#kolcsonzo').show()
					$('#belepes').hide()
				} else if ($('#add_allapotSelect option:selected').data('id') == "5") {
					$('#kolcsonzo').hide()
					$('#belepes').show()
				} else if ($('#add_allapotSelect option:selected').data('id') == "6") {
					$('#kolcsonzo').show()
					$('#belepes').show()
				} else {
					$('#kolcsonzo').hide()
					$('#belepes').hide()
				}
			};
			$("#add_button").click(function() {
				var nev = $('#add_dolgozoNev').val()
				var terulet = $('#add_teruletSelect option:selected').data('id')
				var pozicio = $('#add_pozicioSelect option:selected').data('id')
				var allapot = $('#add_allapotSelect option:selected').data('id')
				var kolcsonzo = $('#kolcsonzoCeg option:selected').val()
				// if (kolcsonzo == 'Munkaland') {
				// 	var newNev = nev + ' ML'
				// }
				// else if (kolcsonzo == 'Getwork'){
				// 	var newNev = nev + ' GW'
				// } else {
				var newNev = nev + ' ' + kolcsonzo
				//}
				var datum = ''
				if ($('#belepesIdo').val().length < 1) {
					var d = new Date();
					datum = d.getFullYear() + '.' + (d.getMonth() + 1) + '.' + d.getDate()
				} else {
					datum = $('#belepesIdo').val()
				}
				$.ajax({
					url: "addDolgozo.php",
					type: "POST",
					cache: false,
					data: {
						d_nev: newNev,
						t_id: terulet,
						p_id: pozicio,
						a_id: allapot,
						b_datum: datum
					},
					success: function(addDolgozoResult) {
						if (addDolgozoResult == 'Sikeres') {
							//alert("Sikerült fellvinni az új dolgozót")
						}
						//console.log(addDolgozoResult)
						location.reload()
					},
					error: function(error) {
						//console.log(error)
					}
				});
			});













			$('#editModal').on('show.bs.modal', function(event) {
				udpateHiddenStats()
				var button = $(event.relatedTarget) // Button that triggered the modal
				var d_nev = button.data('id')
				$(this).attr('data-id', d_nev)
				// var d_terulet = button.data('terulet')//$('#d_ter').text()
				// var d_allapot = button.data('allapot')//$('#d_allapot').text()
				// var d_pozicio = button.data('pozicio')//$('#d_pozi').text()
				var nev = button.data('whatever') // Extract info from data-* attributes
				// var allapot_id = button.data('id')
				//console.log(nev)
				var pozicio_id = button.data('pozicio')
				//console.log(pozicio_id)
				var terulet_id = button.data('terulet')
				//console.log(terulet_id)
				var allapot_id = button.data('allapot')
				//console.log(allapot_id)
				var dolgozo_id = button.data('id')
				//console.log(dolgozo_id)
				var belepes = button.data('belepes')
				var sor = button.data('sor')
				var modal = $(this)
				modal.find('#Modaltitle').text(nev + " szerkesztése")
				modal.find('#edit_dolgozo-nev').val(nev)
				modal.find('#edit_belepes').val(belepes)

				//Terület lekérdezése
				$.ajax({
					url: "getUserTerulet.php",
					type: "POST",
					cache: false,
					data: {
						t_id: terulet_id
					},
					success: function(dataResult_terulet) {
						$('#edit_terulet_select').html(dataResult_terulet);
					},
					error: function(error) {
						//console.log(error)
					}
				});
				//Pozicíó lekérdezése
				if (terulet_id != 7) {
					$('#edit_sorSel').hide()
					$.ajax({
						url: "getPozicioForUserAdd.php",
						type: "POST",
						cache: false,
						data: {
							t_id: terulet_id,
							p_id: pozicio_id
						},
						success: function(dataResult_pozi) {
							//console.log(dataResult_pozi)
							$('#edit_pozicio_select').html(dataResult_pozi);
						},
						error: function(error) {
							//console.log(error)
						}
					});
				} else {
					$('#edit_sorSel').show()
					$.ajax({
						url: "php/getSorok_2.php", 
						type: "POST",
						cache: false,
						data: {
							t_id: terulet_id,
							sor: sor
							
						},
						success: function(getPozicioResult) {
							var obj = JSON.parse(getPozicioResult);
							var lines = [];
							var pozik = []
							if (obj.length > 0) {
								for (var i = obj.length - 1; i >= 0; i--) {
									//lines += '<option class="" data-id="' + obj[i].p_id + '">' + obj[i].p_elnevezes + ' | ' + obj[i].s_elnevezes + '</option>'
									if(obj[i].sid == sor){
										lines += '<option class="" data-sor="' + obj[i].sid + '" selected>' + obj[i].selnev + '</option>'
									}else{
										lines += '<option class="" data-sor="' + obj[i].sid + '">' + obj[i].selnev + '</option>'
									}
									if(obj[i].p_id == pozicio_id)
									{
										pozik += '<option class="" data-id="' + obj[i].p_id + '" selected>' + obj[i].p_elnevezes + '</option>'
									}else{
										pozik += '<option class="" data-id="' + obj[i].p_id + '">' + obj[i].p_elnevezes + '</option>'
									}
								}
							} else {
								lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
							}
							$('#edit_sor_select').html(lines)
							$('#edit_pozicio_select').html(pozik)
						},
						error: function(error) {
							//console.log(error)
						}
					});
					// $.ajax({
					// 	url: "getPozicioForUserAdd.php",
					// 	type: "POST",
					// 	cache: false,
					// 	data: {
					// 		t_id: terulet_id,
					// 		p_id: pozicio_id
					// 	},
					// 	success: function(dataResult_pozi) {
					// 		//console.log(dataResult_pozi)
					// 		$('#edit_pozicio_select').html(dataResult_pozi);
					// 	},
					// 	error: function(error) {
					// 		//console.log(error)
					// 	}
					// });
				}
				//Állapot lekérdezése
				$.ajax({
					url: "getAllapot.php",
					type: "POST",
					cache: false,
					data: {
						a_id: allapot_id
					},
					success: function(dataResult_allapot) {
						$('#edit_allapot_select').html(dataResult_allapot);
					},
					error: function(error) {
						//console.log(error)
					}
				});
			})
			$('#update_button').click(function() {
				var dolgozo_id = $("#editModal").data('id')
				var terulet_id = $("#edit_terulet_select option:selected").data('id')
				var pozicio_id = $("#edit_pozicio_select option:selected").data('id')
				var allapot_id = $("#edit_allapot_select option:selected").data('id')
				var dolgozo_nev = $("#edit_dolgozo-nev").val()
				var belepes_ido = $('#edit_belepes').val()
				//console.log(dolgozo_nev)
				$.ajax({
					url: "updateUser.php",
					type: "POST",
					cache: false,
					data: {
						d_id: dolgozo_id,
						p_id: pozicio_id,
						t_id: terulet_id,
						a_id: allapot_id,
						d_nev: dolgozo_nev,
						belepes: belepes_ido
					},
					success: function(updateDataResult) {
						//console.log(updateDataResult);
						//alert("update success");
						location.reload();

					},
					error: function(error) {
						//console.log(error)
					}
				});

			});
			$('#edit_sor_select').change(function() {
				var sor = $('#edit_sor_select :selected').data('id')

			})
			$('#edit_terulet_select').change(function() {
				//alert('változott')
				var t_id = $('#edit_terulet_select option:selected').data('id')
				var s_id = $('#edit_sor_select option:selected').data('id')
				var pozi_select = $('#edit_pozicio_select')
				////console.log(t_id)
				if (t_id == '7') {
					sorokKezelese('#edit_terulet_select :selected', '#edit_sor_select')
					$.ajax({
						url: "php/getSorok_2.php",
						type: "POST",
						cache: false,
						data: {
							t_id: t_id,
							sor: s_id
						},
						success: function(getPozicioResult) {
							var obj = JSON.parse(getPozicioResult);
							var lines = [];
							if (obj.length > 0) {
								for (var i = obj.length - 1; i >= 0; i--) {
									lines += '<option class="" data-id="' + obj[i].p_id + '">' + obj[i].p_elnevezes + '</option>'
								}
							} else {
								lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
							}
							$('#edit_pozicio_select').html(lines)



						},
						error: function(error) {
							//console.log(error)
						}
					});
				} else {
					$('#edit_sorSel').hide()
					$.ajax({
						url: "getPozicioForUserAdd.php",
						type: "POST",
						cache: false,
						data: {
							t_id: t_id
						},
						success: function(getPozicioResult) {
							//console.log(getPozicioResult);
							//alert("update success");
							$('#edit_pozicio_select').html(getPozicioResult);

						},
						error: function(error) {
							//console.log(error)
						}
					});
				}
			});
			$('#export').click(function() {
				
				var t_id = $('#export').data('terulet');
				window.open("excel/ex.php?id=" + t_id, "_blank")
			});

			
		</script>
	</body>
</html>
<?php } ?>