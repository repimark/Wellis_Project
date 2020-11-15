<?php  
session_start();
if (!isset($_SESSION["u_id"])) {
	header("location: login.php");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dolgozók</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
	include("contents/navbar.php");
	include 'connect.php';
 ?>
	<h1 class="text-center">Dolgozók</h1>
	<div class="container-sm">
	<table border=1 class='table table-striped'>
	<thead class="thead-dark">	
		<th>Név</th>
		<th>Terület</th>
		<th>Pozíció</th>
		<th>Állapot</th>
		<th>Műveletek</th>
	</thead>
	<tbody>
		<!-- DOLGOZÓK KILISTÁZÁSA -->
		<?php include('getUsers.php');?>
	</tbody>
	</table>

	<!-- FELUGRO ABLAK KEZDETE -->
	<div class="modal" tabindex="-1" id="exampleModal">
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
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="update_button" class="btn btn-primary">Save changes</button>
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
          	<label for="kilepo">Szeretnéd a kiléptetett dolgoóz igényként felvenni ?</label>
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

	</div>
	<script type="text/javascript">
		$('#deleteModal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var nev = button.data('nev')
			var dolgozo_id = button.data('id')
			var pozicio_id = button.data('pozicio')
			var terulet_id = button.data('terulet')
			var allapot_id = button.data('allapot')
			var modal = $(this)
			modal.find('#Modaltitle').text(nev + " kiléptetése")
			modal.find('#dolgozo-nev').val(nev)
			modal.find('#delete_button').attr('data-pozicio', pozicio_id)
			modal.find('#delete_button').attr('data-terulet', terulet_id)
			modal.find('#delete_button').attr('data-allapot', allapot_id)
			modal.find('#delete_button').attr('data-id',dolgozo_id)
		});
		$('#delete_button').click(function(){
			var button = $(this)
			var dolgozo_id = button.data('id')
			var pozicio_id = button.data('pozicio')
			var terulet_id = button.data('terulet')
			var allapot_id = button.data('allapot')
			if ($('#kilepo').is(':checked')) {
				//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTELLEL
				alert('igényként kell felvenni id'+dolgozo_id+' pozi_id'+ pozicio_id+' terület_id '+terulet_id+' allapot_id'+allapot_id)
				location.reload()
			}else{
				//KILÉPTETŐ ELKÉSZÍTÉSE IGÉNYFELVÉTEL NÉLKÜL
				alert('nem kell igényként felvenni')
				location.reload()
			}
		});

  		$('#exampleModal').on('show.bs.modal', function (event) {
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
		  var dolgozo_id = $('#exampleModal').data('id')
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
		  		t_id: terulet_id
		  	},
		  	success: function(dataResult_pozi){
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
			var dolgozo_id = $("#exampleModal").data('id')
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
</body>
</html>
<?php } ?>