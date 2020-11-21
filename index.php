<?php  
session_start();
if (!isset($_SESSION["u_id"])) {
  header("location: login.php");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wellis igényfelmérés</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<style type="text/css">
  		.card-header {
      background: #232526;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to top, #414345, #232526);   Chrome 10-25, Safari 5.1-6 
      background: linear-gradient(to top, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */*/
      color:white;

      }
      .btn-reszletek{
      background-color: #343a40;  /* fallback for old browsers */
      /*background: -webkit-linear-gradient(to bottom, #414345, #232526);   Chrome 10-25, Safari 5.1-6 
      background: linear-gradient(to bottom, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      /*color: grey;*/
      color: rgba(255,255,255,.5);
      
      }
      .btn-reszletek:hover{
        color: rgba(255,255,255,.75);
      }

      .card-header h5 a{
        color: rgba(255,255,255,.5);
      }
      .card-header h5 a:hover{
         color:  rgba(255,255,255,.75);
      }

  	</style>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
</head>
<body>

<?php
//Ide kérjük be a fejlécet a menüt és az adatbázis kapcsolatot nyitjuk meg 
require('contents/navbar.php');
require('connect.php');
?>
<div class="container" style="width: 90%">
	<div class="card-columns mr-auto p-2">
		<?php include('getTerulet.php'); ?>
	</div>

</div>
</body>
</html>
<?php } ?>