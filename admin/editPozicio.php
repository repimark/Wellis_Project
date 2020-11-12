<?php  
session_start();
if (!isset($_SESSION["a_id"])) {
	//echo "Nincs itt semmi keresnivalód ! ";
	header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php include '../contents/links.php'; ?>
</head>
<body>
	<?php include '../contents/adminNavbar.php'; ?>
	<div class="container">
		<h2 class="p-3 text-center">Poziciók</h2>					
		<div class="form-group w-50 p-1">
			<form>
				<label for="#terulet">Terület:</label>
				<select class="form-control" id="terulet"></select>
				<label for="#pozicio">Pozicíó:</label>
				<select class="form-control" id="pozicio"></select>
				<button class="btn btn-primary" id="deletePozicio">Pozicíó Törlése</button>
				<button class="btn btn-success" id="addPozicio" data-toggle="modal" data-target="#addModal">Pozicíó létrehozása</button>
				<button class="btn btn-warning" id="movePozicio">Pozició Áthelyezése <span class="badge badge-danger">Beta</span></button>
			</form>
		</div>
		<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Pozició módosítása</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<p>Biztosan szeretnéd kitörölni ? </p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary deleteTerulet" id="editBtn">Módosítás</button>
		      </div>
		    </div>
		  </div>
		</div>
	
		<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Pozició törlése</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<p>Biztosan szeretnéd kitörölni a poziciót?</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary deleteTerulet" id="deleteBtn">Törlés</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<script type="text/javascript">
		$('#addModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var ter = button.data('terulet') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('#deleteBtn').data('terulet',ter)
		  //modal.find('.modal-body input').val(recipient)
		});
		
		$('#terulet').on('change', function(){
			//alert('valtozott')
			var data = $('#terulet :selected').data('terulet')
			//alert(data)
			$.ajax({
				url: 'php/getPozicio.php',
				type: 'POST',
				cache: false,
				data: {
					t_id : data
				},
				success: function(Result){
					var obj = JSON.parse(Result);
					var lines = [];
					if (obj.length > 1) {
						for (var i = obj.length - 1; i >= 0; i--) {
							lines += '<option class="" data-pozicio="'+obj[i].p_id+'">'+obj[i].p_elnevezes+'</option>'
						}
					}else{
						lines+= 'Nincs még hozzárendelve pozicíó ehhez a területhez'
					}
					
					$('#pozicio').html(lines)
				}
			});
		});
		$('.container').ready(function(){
			$.ajax({
				url: 'php/getTerulet.php',
				type: 'POST',
				cache: false,
				success: function(Result){
					var objJSON = JSON.parse(Result);
					var lines = [];
					//alert(objJSON)
  					for (var i = objJSON.length - 1; i >= 0; i--) {
  						lines += '<option class="list-group-item" data-terulet="'+objJSON[i].t_id+'">'+objJSON[i].t_elnevezes+'   </option>'
  					}
  					$('#terulet').html(lines)
				}
			});
		});
	</script>
</body>
</html>
<?php } ?>