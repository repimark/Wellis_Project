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
        <!-- <script src="https://www.gstatic.com/charts/loader.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> -->
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>

    <body>
        <?php
        include("contents/navbar.php");
        ?>
        <div class="container">
            <h1 class="text-center p-5">Fluktuációs adatok</h1>
            <div class="charts bg-light">
                <canvas id="canv"></canvas>
            </div>

        </div>
        <script>
            $('.container').ready(function() {
                //alert('betöltött');
                getDolgozok('#dolgozok-table')
            });
            var terulet = []
            var adatok = []
            var getDolgozok = function(obj) {
                var date = new Date()
                var year = date.getFullYear()
                var month = date.getMonth() + 1
                $.ajax({
                    url: 'php/getFluktuacio.php',
                    type: 'GET',
                    cache: false,
                    data: {
                        ev: year,
                        honap: month
                    },
                    success: function(res) {
                        var objJSON = JSON.parse(res);
                        for (i in objJSON) {
                            terulet.push(objJSON[i].terulet)
                            adatok.push(parseFloat(objJSON[i].fluktu))
                        }
                        rajz()
                    }
                });
            }
            var rajz = function() {

                var chartdata = {
                    labels: terulet,
                    datasets: [{
                            data: adatok,
                            label: 'Fluktuációs adatok',
                            backgroundColor: 'rgba(255, 118, 117,1.0)',
                            borderColor: 'rgba(255, 118, 117,1.0)',
                            hoverBackgroundColor: 'rgba(200,200,200,1.0)',
                            hoverBorderColor: 'rgba(200,200,200,1.0)',
                            borderWidth: 1
                        },
                        
                    ],
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                            position: 'top'
                        }
                    }
                };
                var ctx = document.getElementById('canv').getContext('2d');
                var barGraph = new Chart(ctx, {
                    type: 'pie',
                    data: chartdata
                });
            }
        </script>
    </body>

    </html>
<?php } ?>