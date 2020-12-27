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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
  	<link rel="stylesheet" type="text/css" href="style.css">
  	<style>
        #search{
            display:block;
            width:200px;
            min-height: 100px;
            background-color: white;
            border-radius:4px;
            padding: 5px;
            
            box-shadow: 3px 3px 0px 0px ;
            position:relative;
        }
        #search button{
            align:center;
            
            
        }
    </style>
</head>
<body>
<?php 
	include("contents/navbar.php");
 ?>
 <div class="container">
    <h1 class="text-center p-5">Igény Változások </h1>
    <div id="search">
        <label for="#date" class="p-0 text">Válassz dátumot</label>
        <br>
        <input type="date" id="date" class="form-control"/>
        <br>
        <button class="btn btn-info">Változások lekérdezése</button>
        
    </div>
    <div id="igenyek">

    </div>

 </div>
 <script>
    $('.container').ready(function(){
        //alert('betöltött');
        getDolgozok('#igenyek')
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
  					//$(obj).html(lines)
            }
        });
    }
 </script>
</body>
</html>
<?php } ?>