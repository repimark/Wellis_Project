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
        include 'contents/navbar.php';
        ?>
        <div class="container">
            <h2 class="text-center">Be- és Kilépett Dolgozók</h2>
            <div id="chart_cont">
                <canvas id="canv1" width="500" height="300" style="background-color: white;"></canvas>
                <canvas id="canv2" width="500" height="300" style="background-color: white;"></canvas>
            </div>
        </div>
        <script type="text/javascript">
            $('.container').ready(function() {
                var datum = new Date()
                var y = datum.getFullYear()
                var m = datum.getMonth() + 1
                console.log(m)
                loadDolgozok(y,m)
                loadKilepett(2021,1)
            });
            var loadDolgozok = function(year, month) {
                $.ajax({
                    url: "adatok/getHaviDolgozok.php",
                    method: "POST",
                    data: {
                        year: year,
                        month: month
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data)
                        var terulet = []
                        var adat = []
                        for (i in data) {
                            terulet.push(data[i].terulet)
                            adat.push(data[i].db)
                            //console.log(adat[i])
                        }
                        var chartdata = {
                            labels: terulet,
                            datasets: [{
                                label: 'A hónapban belépett dolgozók',
                                backgroundColor: 'rgba(200,200,200,0.75)',
                                borderColor: 'rgba(200,200,200,0.75)',
                                hoverBackgroundColor: 'rgba(200,200,200,1)',
                                hoverBorderColor: 'rgba(200,200,200,1)',
                                borderWidth: 1,
                                data: adat
                            }]
                        };
                        var ctx = document.getElementById('canv1').getContext('2d');
                        var barGraph = new Chart(ctx, {
                            type: 'bar',
                            data: chartdata,
                            options: {
                                tooltips: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                scales: {
                                    y: {
                                            beginAtZero: true
                                        }
                                }
                            }
                        });

                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
            var loadKilepett = function(year, month) {
                $.ajax({
                    url: "adatok/getHaviKilepett.php",
                    method: "POST",
                    data: {
                        year: year,
                        month: month
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data)
                        var terulet = [];
                        var adat = [];
                        for (i in data) {
                            terulet.push(data[i].terulet)
                            adat.push(data[i].db)
                            //console.log(adat[i])
                        }
                        var chartdata = {
                            labels: terulet,
                            datasets: [{
                                data: adat,
                                label: 'A hónapban Kilépett dolgozók',
                                backgroundColor: 'rgba(200,200,200,0.75)',
                                borderColor: 'rgba(200,200,200,0.75)',
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
                        var ctx = document.getElementById('canv2').getContext('2d');
                        var barGraph = new Chart(ctx, {
                            type: 'bar',
                            data: chartdata
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>