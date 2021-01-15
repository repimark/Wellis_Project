<?php  
session_start();
if (!isset($_SESSION["a_id"])) {
	header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wellis Admin oldal</title>
	<?php include '../contents/links.php'; ?>
</head>
<body>
	<?php include '../contents/AdminNavbar.php'; ?>
	<div class="container">
		<h2 class="p-3 text-center">Poziciók</h2>					
		<div class="form-group p-1" style="width:58%">
			<form>
				<label for="#terulet">Terület:</label>
				<select class="form-control" id="terulet"></select>
				<label for="#pozicio">Pozicíó:</label>
				<select class="form-control" id="pozicio"></select>
			</form>
			<br>
			<button class="btn btn-danger" id="deletePozicio" data-toggle="modal" data-target="#deleteModal">Pozicíó Törlése</button>
				<button class="btn btn-success" id="addPozicio" data-toggle="modal" data-target="#addModal">Pozicíó létrehozása</button>
				<button class="btn btn-info" id="movePozicio" data-toggle="modal" data-target="#moveModal">Pozició Áthelyezése</button>
				<button class="btn btn-warning" id="editPozicio" data-toggle="modal" data-target="#editModal">Pozició Módosítása</button>
		</div>
		<!-- HOZZÁADÁS -->
		<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Pozició létrehozása</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<label for="pozicio">Új pozicíó neve:</label>
		      	<input type="text" name="pozicio" id="newPozi" class="form-control">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary addBtn" id="addBtn">Létrehozás</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- TÖRLÉS -->
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
		<!-- ÁTHELYEZÉS -->
		<div class="modal fade" id="moveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Pozició áthelyezése</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="form-group">
		      		<label for="#moveTerulet" id="moveTeruletLabel">Hova szeretnéd áthelyezni (X) pozíciót ? </label>
		      		<select class="form-control" id="moveTerulet"></select>
		      	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary movePozicio" id="moveBtn">Áthelyezés</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- MÓDOSÍTÁS -->
		<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Pozició módosítása</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="form-group">
		      		<label for="#poziInput" id="editPozicioLabel">A pozíció új neve</label>
		      		<input class="form-control" id="poziInput"></input>
		      	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary editPozicio" id="editBtn">Módosítás</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
	<script type="text/javascript">
		$('#terulet').on('change', function(){
			//alert('valtozott')
			if($('#terulet :selected').data('terulet') == '7'){
				getSorokPozicio('#pozicio')
			}else{
				getPozicio('#pozicio')
			}
		});
		var getSorokPozicio = function(pozicio){
			var data = $('#terulet :selected').data('terulet')
			//alert(data)
			$.ajax({
				url: 'php/getSorok.php',
				type: 'POST',
				cache: false,
				data: {
					t_id : data
				},
				success: function(Result){
					var obj = JSON.parse(Result);
					var lines = [];
					if (obj.length > 0) {
						for (var i = obj.length - 1; i >= 0; i--) {
							lines += '<option class="" data-pozicio="'+obj[i].p_id+'">'+obj[i].p_elnevezes+','+ obj[i].s_elnevezes+'</option>'
						}
					}else{
						lines+= 'Nincs még hozzárendelve pozicíó ehhez a területhez'
					}
					$(pozicio).html(lines)
				}
			});
		};
		var getPozicio = function(pozicio){
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
					if (obj.length > 0) {
						for (var i = obj.length - 1; i >= 0; i--) {
							lines += '<option class="" data-pozicio="'+obj[i].p_id+'">'+obj[i].p_elnevezes+'</option>'
						}
					}else{
						lines+= 'Nincs még hozzárendelve pozicíó ehhez a területhez'
					}
					$(pozicio).html(lines)
				}
			});
		};

		$('#addModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var ter = $('#terulet :selected').data('terulet')
		  var modal = $(this)
		  modal.find('#addBtn').data('terulet', ter)
		});

		$('#deleteModal').on('show.bs.modal', function (event) {
		  var ter = $('#terulet :selected').data('terulet')
		  var pozi = $('#pozicio :selected').data('pozicio')
		  var poziNev = $('#pozicio :selected').val()
		  var modal = $(this)
		  modal.find('.modal-body').html('<p>Biztosan szeretnéd kitörölni a '+poziNev+' poziciót?</p>')
		  modal.find('#deleteBtn').data('pozicio', pozi)
		});
		$('#moveModal').on('show.bs.modal', function (event) {
		  //var ter = $('#terulet :selected').data('terulet')
		  var pozi = $('#pozicio :selected').data('pozicio')
		  var poziNev = $('#pozicio :selected').val()
		  getTerulet('#moveTerulet')
		  var modal = $(this)
		  modal.find('#moveTeruletLabel').html('<p>Hova szeretnéd áthelyezni '+poziNev+' pozíciót ?</p>')
		  
		  modal.find('#moveBtn').data('pozicio', pozi)
		});
		$('#editModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var pozi =  $('#pozicio :selected').data('pozicio')
		  var modal = $(this)
		  modal.find('#editBtn').data('pozicio', pozi)
		});
		$('#editBtn').click(function(event){
			var newPozi = $('#poziInput').val()
			//var button = $(event.relatedTarget)
			var pozi = $('#editBtn').data('pozicio')
			//alert(pozi+'új neve'+newPozi)
			$.ajax({
				url: 'php/editPozicio.php',
				type: 'POST',
				cache: false,
				data: {
					p_id: pozi,
					p_elnevezes: newPozi
				},
				success: function(Result){
					if (Result == 'Sikeres') {
						location.reload()
					}else{
						alert('Sikertelen')
					}
				}	
			});
		});
		$('#addBtn').click(function(event){
			var ter = $(this).data('terulet')
			var pozi = $('#newPozi').val()
			$.ajax({
				url: 'php/addPozicio.php',
				type: 'POST',
				cache: false,
				data: {
					elnev: pozi,
					t_id: ter
				},
				success: function(Result){
					if (Result == 'Sikeres') {
						location.reload()
						
					}
				}
			});
		});

		$('#deleteBtn').click(function(event){
			var pozi = $(this).data('pozicio')
			$.ajax({
				url: 'php/deletePozicio.php',
				type: 'POST',
				cache: false, 
				data: {
					p_id: pozi
				},
				success: function(Result){
					//console.log(Result)
					if (Result == 'Sikeres') {
						location.reload()
					}
				}
			});
		});
		
		$('#moveBtn').click(function(event){
			var pozi = $(this).data('pozicio')
			var terulet = $('#moveTerulet :selected').data('terulet')
			$.ajax({
				url: 'php/movePozicio.php',
				type: 'POST',
				cache: false, 
				data: {
					p_id: pozi,
					t_id: terulet
				},
				success: function(Result){
					//console.log(Result)
					if (Result == 'Sikeres') {
						location.reload()
					}
				}
			});
		});

		var getTerulet = function(terulet){
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
  					$(terulet).html(lines)
  					getPozicio('#pozicio')		
				}
			});
		};

		$('.container').ready(function(){
			getTerulet('#terulet')
			
		});
	</script>
</body>
</html>
<?php } ?>