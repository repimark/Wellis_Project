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
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>

    <body>

        <?php
        include 'contents/navbar.php';
        ?>
        <div class="container">
            <h2 class="text-center">Be- és Kilépett Dolgozók</h2>
            <div id="chart_cont">
                <canvas id="canv1"></canvas>
                <canvas id="canv2"></canvas>
            </div>
        </div>
        <script type="text/javascript">
            $('#chart_div').ready(function() {
                loadDolgozok()
                loadKilepett()
            });
            var loadDolgozok = function() {
                $.ajax({
                    url: "adatok/getHaviDolgozok.php",
                    method: "POST",
                    data: {
                        year: 2021,
                        month: 1
                    },
                    dataType: "JSON",
                    success: function(data) {
                        //console.log(data)
                        var terulet = []
                        var adat = []
                        for (i in data) {
                            terulet.push(data[i].terulet)
                            adat.push(data[i].db + 6)
                            //console.log(adat[i])
                        }
                        var chartdata = {
                            labels: terulet,
                            dataset: [{
                                label: 'Terület',
                                backgroundColor: 'rgba(200,200,200,0.75)',
                                borderColor: 'rgba(200,200,200,0.75)',
                                hoverBackgroundColor: 'rgba(200,200,200,1)',
                                hoverBorderColor: 'rgba(200,200,200,1)',
                                data: adat
                            }]
                        };
                        var ctx = document.getElementById('canv1');
                        var barGraph = new Chart(ctx, {
                            type: 'line',
                            data: chartdata
                        });

                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }
            var loadKilepett = function() {
                $.ajax({
                    url: "adatok/getHaviKilepett.php",
                    method: "POST",
                    data: {
                        year: 2021,
                        month: 1
                    },
                    dataType: "JSON",
                    success: function(data) {
                        //console.log(data)
                        var terulet = []
                        var adat = []
                        for (i in data) {
                            terulet.push(data[i].terulet)
                            adat.push(data[i].db + 8)
                            console.log(adat[i])
                        }
                        var chartdata = {
                            labels: terulet,
                            dataset: [{
                                data: adat,
                                label: 'Terület',
                                backgroundColor: 'rgba(200,200,200,0.75)',
                                borderColor: 'rgba(200,200,200,0.75)',
                                hoverBackgroundColor: 'rgba(200,200,200,1.0)',
                                hoverBorderColor: 'rgba(200,200,200,1.0)',
                                borderWidth: 1
                                
                            }]
                        };
                        var ctx = document.getElementById('canv2').getContext('2d');
                        var barGraph = new Chart(ctx, {
                            type: 'line',
                            data: chartdata
                        })

                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>