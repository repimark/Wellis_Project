<?php  
session_start();
if (!isset($_SESSION["a_id"])) {
	header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wellis Felhasználók kezelése</title>
	<?php include '../contents/links.php'; ?>
</head>
<body>
	<?php include '../contents/adminNavbar.php'; ?>
	<div class="container">
		<h1 class="text-center">Felhasználók kezelése</h1>
		<div class="users">
			<h3>Felhasználók</h3>
			<ul class="list-group" id="users">
				
			</ul>
		</div>
		<br>
		<div class="admin-users">
			<h3>Admin Felhasználók</h3>
			<ul class="list-group" id="adminUsers">
				
			</ul>
		</div>
		<!-- ADD MODAL -->
		<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Felhasználó hozzáadása</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form>
		        	<label class="form-group" for="#unameInput">Felhasználónév</label>
		        	<input type="text" id="unameInput" class="form-control" placeholder="Felhasználónév" focus></form>
		        	<label class="form-group" for="#passInput">Jelszó</label>
		        	<input type="password" class="form-control" id="passInput" placeholder="Jelszó"></input>
		        	<label class="form-group" for="#passInput2">Jelszó Megerősítése</label>
		        	<input type="password" class="form-control" id="passInput2" placeholder="Jelszó Megerősítése"></input>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary addUser">Mentés</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<!-- DELETE MODAL -->
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Felhasználó törlése</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<p>Biztosan szeretnéd kitörölni ? </p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary deleteUser" id="deleteBtn">Törlés</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>


		<!-- ADD ADMIN MODAL -->
		<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Admin Felhasználó hozzáadása</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form>
		        	<label class="form-group" for="#aNameInput">Felhasználónév</label>
		        	<input type="text" id="aNameInput" class="form-control" placeholder="Felhasználónév" focus></form>
		        	<label class="form-group" for="#aPassInput">Jelszó</label>
		        	<input type="password" class="form-control" id="aPassInput" placeholder="Jelszó"></input>
		        	<label class="form-group" for="#aPassInput2">Jelszó Megerősítése</label>
		        	<input type="password" class="form-control" id="aPassInput2" placeholder="Jelszó Megerősítése"></input>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        <button type="button" class="btn btn-primary addAdmin">Mentés</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<!-- DELETE ADMIN MODAL -->
		<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h5 class="modal-title" id="exampleModalLabel">Admin felhasználó törlése</h5>
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          			<span aria-hidden="true">&times;</span>
		        		</button>
		      		</div>
		      		<div class="modal-body">
		      			<p>Biztosan szeretnéd kitörölni ? </p>
		      		</div>
		      		<div class="modal-footer">
		        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
		        		<button type="button" class="btn btn-primary deleteAdminUser" id="deleteAdminBtn">Törlés</button>
		      		</div>
		    	</div>
		  	</div>
		</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			getUsers()
			getAdminUsers()
		});
		var getUsers = function (){
			$.ajax({
				url: 'php/getUsers.php',
				type: 'POST',
				cache: false,
				success: function(Result){
					//alert(Result)
					var objJSON = JSON.parse(Result);
					var lines = '<li class="list-group-item add"><button onclick="" data-toggle="modal" data-target="#addModal" class="btn addNew"><span class="text-success">+</span>Új Felhasználó hozzáadása</button></li>';
					//alert(objJSON)
  					for (var i = objJSON.length - 1; i >= 0; i--) {
  						lines += '<li class="list-group-item">'+objJSON[i].u_name+' <button data-user="'+objJSON[i].u_id+'" id="delBtn"  data-target="#deleteModal" data-toggle="modal" class="btn badge badge-danger">Törlés</button></li>'
  					}
  					$('#users').html(lines)
				}
			});
		};

		var getAdminUsers = function (){
			$.ajax({
				url: 'php/getAdminUsers.php',
				type: 'POST',
				cache: false,
				success: function(Result){
					//alert(Result)
					var objJSON = JSON.parse(Result);
					var lines = '<li class="list-group-item add"><button onclick="" data-toggle="modal" data-target="#addAdminModal" class="btn addNew"><span class="text-success">+</span>Új Admin Felhasználó hozzáadása</button></li>';
					//alert(objJSON)
  					for (var i = objJSON.length - 1; i >= 0; i--) {
  						lines += '<li class="list-group-item">'+objJSON[i].a_name+' <button data-admin="'+objJSON[i].a_id+'" id="delBtn"  data-target="#deleteAdminModal" data-toggle="modal" class="btn badge badge-danger">Törlés</button></li>'
  					}
  					$('#adminUsers').html(lines)
				}
			});
		};
		$('.addUser').click(function(){
			var uName = $('#unameInput').val()
			var uPass = $('#passInput').val()
			var uPass2 = $('#passInput2').val()
			if (uPass == uPass2) {
				$.ajax({
					url: 'php/addUser.php',
					type: 'POST',
					cache: false, 
					data: {
						uName: uName,
						uPass: uPass
					},
					success: function(Result){
						if (Result == 'Sikeres') {
							location.reload()
						}else{
							alert('Sikertelen')
						}
					}
				});
			}else{
				alert('Nem egyezik a két jelszó')
			}
		});

		$('.addAdmin').click(function(){
			var aName = $('#aNameInput').val()
			var aPass = $('#aPassInput').val()
			var aPass2 = $('#aPassInput2').val()
			if (aPass == aPass2) {
				$.ajax({
					url: 'php/addAdminUser.php',
					type: 'POST',
					cache: false, 
					data: {
						aName: aName,
						aPass: aPass
					},
					success: function(Result){
						if (Result == 'Sikeres') {
							location.reload()
						}else{
							alert('Sikertelen')
						}
					}
				});
			}else{
				alert('Nem egyezik a két jelszó')
			}
		});
		$('#deleteModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var user = button.data('user') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('#deleteBtn').data('userId',user)
		  //modal.find('.modal-body input').val(recipient)
		})

		$('#deleteAdminModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var user = button.data('admin') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('#deleteAdminBtn').data('adminId',user)
		  //modal.find('.modal-body input').val(recipient)
		})
		$('.deleteUser').click(function(event){

			var user = $(this).data('userId')
			//alert(ter)

			$.ajax({
				url: 'php/deleteUser.php',
				type: 'POST',
				cache: false, 
				data: {
					u_id: user
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

		$('.deleteAdminUser').click(function(event){

			var user = $(this).data('adminId')
			//alert(ter)

			$.ajax({
				url: 'php/deleteAdmin.php',
				type: 'POST',
				cache: false, 
				data: {
					a_id: user
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
	</script>
</body>
</html>
<?php } ?>