<?php
session_start();
if (!isset($_SESSION["u_id"])) {
    header("location: login.php");
} else {
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
        <!-- <script src="https://www.gstatic.com/charts/loader.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> -->
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>

    <body>
        <?php
        //Ide kérjük be a fejlécet a menüt és az adatbázis kapcsolatot nyitjuk meg 
        if ($_SESSION["jog"] == "1") {
            require('contents/navbar.php');
        } else if ($_SESSION["jog"] == "2") {
            require('contents/userNavbar.php');
        }
        ?>
        <div class="container">
            <br>
            <h2 class="text-center">Igények poziciónként</h2>
            <br>
            <ul class="list-group list-group-flush rounded" id="result">

            </ul>
            <br>
        </div>
        <script>
            $(document).ready(function(){
                loadIgenyek()
            })
            var loadIgenyek = function(){
                $.ajax({
                    url: 'php/getPoziIgeny.php',
                    type: 'GET',
                    success: function(res){
                        //console.log(res)
                        var obj = JSON.parse(res)
                        var lines = []
                        for (i in obj){
                            if(obj[i].ter == '-'){
                                lines += '<hr>'
                            }else{
                                lines += '<li class="list-group-item"> Terület : <span class="text-success">' + obj[i].ter + '</span> Pozicíó : <span class="text-info">' + obj[i].poz + '</span> Igény : <span class="text-danger">' + obj[i].ig + '</span></li>' 
                            }
                        }
                        $('#result').html(lines)
                    },
                    error: function(errRes){
                        console.log(errRes)
                    }
                })
            }
        </script>
    </body>

    </html>
<?php } ?>