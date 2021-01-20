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
        
        if ($_SESSION["jog"] == "1") {
            require('contents/navbar.php');
        } else if ($_SESSION["jog"] == "2") {
            require('contents/userNavbar.php');
        }
        ?>
        <div class="container">
            <h1 class="text-center p-5">Fluktuációs adatok</h1>
            <div class="charts bg-light">
                <canvas id="canv" class="bg-light rounded shadow mb-5"></canvas>
            </div>

        </div>
        <script>
            $('.container').ready(function() {
                //alert('betöltött');
                getDolgozok('#dolgozok-table')
            });
            var terulet = []
            var belepesi = []
            var kilepesi = []
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
                            belepesi.push(parseFloat(objJSON[i].be))
                            kilepesi.push(parseFloat(objJSON[i].ki))

                        }
                        rajz()
                    }
                });
            }
            var rajz = function() {

                var chartdata = {
                    
                    labels: terulet,
                    datasets: [{
                            data: belepesi,
                            label: 'Belépési adatok',
                            backgroundColor: ['rgba(252, 92, 101,0.75)','rgba(253, 150, 68,0.75)','rgba(38, 222, 129,0.75)','rgba(43, 203, 186,0.75)','rgba(69, 170, 242,0.75)','rgba(75, 123, 236,0.75)','rgba(165, 94, 234,0.75)','rgba(209, 216, 224,0.75)','rgba(119, 140, 163,0.75)','rgba(254, 211, 48,0.75),rgba(235, 59, 90,0.75)','rgba(32, 191, 107,0.75)', 'rgba(75, 101, 132,0.75)'],
                            borderColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            hoverBackgroundColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            hoverBorderColor: 'rgba(0,0,0,1.0)',
                            borderWidth: 1
                        },
                        {
                        data: kilepesi,
                            label: 'Kilépési adatok',
                            backgroundColor: ['rgba(252, 92, 101,0.75)','rgba(253, 150, 68,0.75)','rgba(38, 222, 129,0.75)','rgba(43, 203, 186,0.75)','rgba(69, 170, 242,0.75)','rgba(75, 123, 236,0.75)','rgba(165, 94, 234,0.75)','rgba(209, 216, 224,0.75)','rgba(119, 140, 163,0.75)','rgba(254, 211, 48,0.75),rgba(235, 59, 90,0.75)','rgba(32, 191, 107,0.75)', 'rgba(75, 101, 132,0.75)'],
                            borderColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            hoverBackgroundColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            hoverBorderColor: 'rgba(0,0,0,1.0)',
                            borderWidth: 1
                        }
                    ],
                    options: {
                        tooltips: {

                        },
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
                    type: 'bar',
                    data: chartdata,
                    options: {
                        title: { 
                            display: true,
                            text: 'Be és Kilépési adatok %-ban'
                        }
                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>