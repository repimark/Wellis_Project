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
            display:inline-block;
            width:200px;
            min-height: 100px;
            background-color: white;
            border-radius:4px;
            padding: 5px;
            margin: 10px;
            box-shadow: 3px 3px 0px 0px ;
            position:relative;
        }
        #search button{
            align:center;
            
            
        }
        #igenyek{
            margin:10px;
            padding: 10px;
        }
        .kimutatas{
            display:inline-block;
            min-height:100px;
            width:300px;
            padding: 5px;
            margin: 10px;
            position:relative;
            border-radius: 4px;
            box-shadow: 3px 3px 0px 0px ;
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
        <input type="month" min="2020-01" value="2020-12"  id="date" class="form-control"/>
        <br>
        <button class="btn btn-info" id="lekerdezes">Változások lekérdezése</button>
        
    </div>
    <div class="kimutatas bg-light">
        <div class="row">
            <div class="col-sm">1</div>
            <div class="col-sm">2</div>
            <div class="col-sm">3</div>
        </div>
        <div class="row">
            <div class="col-sm">4</div>
            <div class="col-sm">5</div>
            <div class="col-sm">6</div>
        </div>
        <div class="row">
            <div class="col-sm">7</div>
            <div class="col-sm">8</div>
            <div class="col-sm">9</div>
        </div>
    </div>
    <div id="igenyek">
        <table class="table table-striped">
        </table>
    </div>

 </div>
 <script>
    $('.container').ready(function(){
        //alert('betöltött');
        //getLog('#igenyek')
    });
    $('#lekerdezes').click(function(){
        var datum = $('#date').val()
        var ev = datum.substr(0,4)
        var honap = datum.substr(5,7)
        console.log(datum+' , '+ev+' , '+honap)

        getLog($('.table'), honap, ev)
    });
    var getLog = function(obj, honap, ev){
        $.ajax({
            url: 'php/getIgenyLog.php',
            type: 'POST',
            cache: false,
            data: {
                ev: ev,
                honap: honap
            },
            success: function(res){
                //console.log(res)
                var objJSON = JSON.parse(res);
                console.log(objJSON)
                    var lines = [];
                    lines += '<thead class="thead-dark"><tr><th>Mennyiség</th><th>Művelet</th><th>Felhasználó</th><th>Hónap</th></tr></thead>'
					lines += '<tbody class="bg-light">'
  					for (var i = 0; i <= objJSON.length-1; i++) {
                          
                          lines += '<tr><td>'+(objJSON[i].mennyiseg)+'</td><td>'+(objJSON[i].iv_muvelet)+'</td><td>'+(objJSON[i].u_name)+'</td><td>'+(objJSON[i].iv_datum)+'</td></tr>'
                          console.log(objJSON[i].mennyiseg)
                      }
                      lines += '</tbody>'
  					$(obj).html(lines)
            }
        });
    }
 </script>
</body>
</html>
<?php } ?>