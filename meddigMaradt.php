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
        <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script> -->
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>

    <body>
        <?php
        include("contents/navbar.php");
        ?>
        <div class="container">
            <h2 class="text-center brand"> Meddig maradtak az emberek </h2>
            <div class="canvas-div w-75"><canvas id="canv1" width="50%"></canvas></div>
        </div>
        <script>
            var evAlatt = 0
            var evFelett = 0
            var labS = ["Kevesebb mint 1 év ", "Több mint 1 év"]
            $('.container').ready(function(){
                loadMaradt()
                
            })
            var loadMaradt = function(){
                $.ajax({
                    url: 'adatok/getMaradasiIdo.php',
                    type: 'POST',
                    data: {},
                    success: function(Result){
                        console.log(Result)
                        var obj = JSON.parse(Result)
                        var lines = [];
                        for ( i in obj){
                            if(obj[i].db > 365){
                                var evOszto = parseInt(obj[i].db / 365)
                                var newDb = parseInt(obj[i].db) - (evOszto * 365)
                                //console.log(+evOszto + ' év '+ newDb + ' nap')
                                evFelett ++;
                                console.log(evFelett)
                            }else{
                            //console.log(obj[i].db + ' nap')
                                evAlatt ++;
                                console.log(evAlatt)
                            }
                        }
                        rajz()
                    },
                    error: function(errorData){
                        console.log(errorData)
                    }
                });
            }
            var rajz = function(){
                console.log(evAlatt)
                console.log(evFelett)
                var chartdata = {
                            labels: labS,
                            datasets: [{
                                data: [parseInt(evAlatt),parseInt(evFelett)],
                                label: 'Ki meddig maradt',
                                backgroundColor: ['rgba(255, 118, 117,1.0)','rgba(0, 184, 148,1.0)'],
                                borderColor: ['rgba(255, 118, 117,1.0)','rgba(0,184,148,1.0)'],
                                hoverBackgroundColor: 'rgba(200,200,200,1.0)',
                                hoverBorderColor: 'rgba(200,200,200,1.0)',
                                borderWidth: 1
                            }],
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                    position: 'top'
                                }
                            }
                        };
                        var ctx = document.getElementById('canv1').getContext('2d');
                        var barGraph = new Chart(ctx, {
                            type: 'bar',
                            data: chartdata
                        });
            }
        </script>
    </body>
    </html>
<?php } ?>