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
	<?php include '../contents/AdminNavbar.php'; ?>
	<div class="container p-5">
		<ul id="list" class="list-group">
			
		</ul>
	</div>
	<script type="text/javascript">
		$('.delBtn').click(function(){
			console.log('pressed')
			alert('így megnyomható')
		});
		$('.addNew').click(function(){
			alert('kezdődik a hozzáadás')
		});
		$('.container').ready(function(){
			$.ajax({
				url: 'php/getTerulet.php',
				type: 'POST',
				cache: false,
				success: function(Result){
					var objJSON = JSON.parse(Result);
					var lines = '<li class="list-group-item"><button class="btn addNew"><span class="text-success">+</span>Új Terület hozzáadása</button></li>';
					//alert(objJSON)
  					for (var i = objJSON.length - 1; i >= 0; i--) {
  						lines += '<li class="list-group-item" data-pozicio="'+objJSON[i].p_id+'" data-terulet="'+objJSON[i].t_id+'">'+objJSON[i].t_elnevezes+' / '+objJSON[i].p_elnevezes+'   <button class="btn delBtn badge badge-danger">Törlés</button></li>'
  					}
  					$('#list').html(lines)
				}
			})
		});
		
	</script>
</body>
</html>
<?php } ?>