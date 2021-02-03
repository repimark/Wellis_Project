<?php
session_start();
if (!isset($_SESSION["a_id"])) {
	//echo "Nincs itt semmi keresnivalód ! ";
	header('location:index.php');
} else {
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Wellis Admin oldal</title>
		<?php include '../contents/links.php'; ?>
		<style type="text/css">
			.add {
				background: #76b852;
				/* fallback for old browsers */
				background: -webkit-linear-gradient(to right, #8DC26F, #76b852);
				/* Chrome 10-25, Safari 5.1-6 */
				background: linear-gradient(to right, #8DC26F, #76b852);
				/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

			}

			.addNew {
				color: white;
			}
		</style>
	</head>

	<body>
		<?php include '../contents/AdminNavbar.php'; ?>
		<div class="container p-5">
			<ul id="list" class="list-group ">

			</ul>

		</div>
		<!-- ADD MODAL -->
		<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Szervezeti egység hozzáadása</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<label class="form-group" for="#newSZE">Szervezeti egység</label>
							<input type="text" name="terulet" id="newSZE" class="form-control">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
						<button type="button" class="btn btn-primary addSZE">Mentés</button>
					</div>
				</div>
			</div>
		</div>
		<!-- DELETE MODAL -->
		<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Szervezeti egység törlése</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Biztosan szeretnéd kitörölni ? </p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
						<button type="button" class="btn btn-primary deleteSZE" id="deleteBtn">Törlés</button>
					</div>
				</div>
			</div>
		</div>
		</div>
		<script type="text/javascript">
			$('.addSZE').click(function() {
				var egys = $('#newSZE').val()
				//alert(ter)
				$.ajax({
					url: 'php/addSZE.php',
					type: 'POST',
					cache: false,
					data: {
						elnev: egys
					},
					success: function(Result) {
						if (Result == 'Sikeres') {
							location.reload()
						} else {
							alert('Sikertelen')
						}
					}
				});
			});
			$('#deleteModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var sze = button.data('id') // Extract info from data-* attributes
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
				modal.find('#deleteBtn').data('id', sze)
				//modal.find('.modal-body input').val(recipient)
			})
			$('.deleteSZE').click(function(event) {

				var egys = $(this).data('id')
				//alert(ter)

				$.ajax({
					url: 'php/deleteSZE.php',
					type: 'POST',
					cache: false,
					data: {
						szt_id: egys
					},
					success: function(Result) {
						if (Result == 'Sikeres') {
							location.reload()
						} else {
							alert('Sikertelen')
						}
					}
				});
			});
			var deleteItem = function(terulet) {
				$.ajax({
					url: 'php/deleteSZE.php',
					type: 'POST',
					cache: false,
					data: {
						t_id: terulet
					},
					success: function(Result) {
						if (Result == 'Sikeres') {
							location.reload()
						} else {
							alert('Sikertelen')
						}
					}
				});
			};
			$('.container').ready(function() {
				var lines = []
				lines += '<li class="list-group-item add"><button onclick="add()" data-toggle="modal" data-target="#addModal" class="btn addNew"><span class="text-success">+</span>Új Szervezeti egység hozzáadása</button></li>';
				$.ajax({
					url: 'php/getSZE.php',
					type: 'POST',
					cache: false,
					success: function(Result) {
						var objJSON = JSON.parse(Result);
						//alert(Result)
						for (i in objJSON) {
							lines += '<li class="list-group-item" data-id="' + objJSON[i].szt_id + '">' + objJSON[i].szt_elnevezes + '   <button data-id="' + objJSON[i].szt_id + '" id="delBtn"  data-target="#deleteModal" data-toggle="modal" class="btn badge badge-danger">Törlés</button></li>'
						}
						//alert(lines)
						$('#list').html(lines)
					},
					error: function(errorRes) {
						console.log(errorRes)
					}
				})
				
			});
		</script>
	</body>

	</html>
<?php } ?>