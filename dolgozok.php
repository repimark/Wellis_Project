<?php  
session_start();
if (!isset($_SESSION["u_id"])) {
	header("location: login.php");
}else{
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
  	
</head>
<body>
<?php 
	include("contents/navbar.php");
 ?>
 <div class="container">
    <h1 class="text-center p-5">Dolgozók </h1>
    <div id="dolgozok-table">

    </div>

 </div>
 <script>
    $('.container').ready(function(){
        //alert('betöltött');
        getDolgozok('#dolgozok-table')
    });

    var getDolgozok = function(obj){
        $.ajax({
            url: 'php/getFluktuacio.php',
            type: 'GET',
            cache: false,
            data: {
                ev: 2020,
                honap: 11
            },
            success: function(res){
                //console.log(res)
                var objJSON = JSON.parse(res);
                console.log(objJSON)
					var lines = [];
					//alert(objJSON)
  					for (var i = 0; i <= objJSON.length-1; i++) {
                          lines += '<p>'+(objJSON[i].d_nev)+'</p>'
                          console.log(objJSON[i].d_nev)
  					}
  					$(obj).html(lines)
            }
        });
    }
 </script>
</body>
</html>
<?php } ?>