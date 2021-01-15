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
        //Ide kérjük be a fejlécet a menüt és az adatbázis kapcsolatot nyitjuk meg 
        if ($_SESSION["jog"] == "1") {
            require('contents/navbar.php');
        } else if ($_SESSION["jog"] == "2") {
            require('contents/userNavbar.php');
        }
        require('connect.php');
        ?>
        <div class="container">
            <h2 class="text-center brand"> Meddig maradtak az emberek </h2>
            <div class="canvas-div "><canvas id="canv1" width="50%" class="bg-light center"></canvas></div>
        </div>
        <script>
            var adat = [];
            var cim = ["Munkaland", "Melicom", "Trankwalder", "Workforce", "ismeretlen"];
            $('.container').ready(function() {
                loadKolcsonzok()

            })
            var loadKolcsonzok = function() {
                $.ajax({
                    url: 'adatok/getKolcsonzottek.php',
                    type: 'POST',
                    data: {},
                    success: function(Result) {
                        console.log(Result)
                        var obj = JSON.parse(Result)
                        var lines = [];
                        adat.push(obj[0].ml)
                        adat.push(obj[0].meli)
                        adat.push(obj[0].trank)
                        adat.push(obj[0].workf)
                        adat.push(obj[0].ism)

                        rajz()
                    },
                    error: function(errorData) {
                        console.log(errorData)
                    }
                });
            }
            var rajz = function() {
                console.log(adat)
                var chartdata = {
                    labels: cim,
                    datasets: [{
                        data: adat,
                        label: 'Kölcsönző cégek megoszlása',
                        backgroundColor: ['rgba(192, 57, 43,1.0)', 'rgba(155, 89, 182,1.0)', 'rgba(26, 188, 156,1.0)', 'rgba(230, 126, 34,1.0)', 'rgba(127, 140, 141,1.0)'],
                        borderColor: ['rgba(192, 57, 43,1.0)', 'rgba(155, 89, 182,1.0)', 'rgba(26, 188, 156,1.0)', 'rgba(230, 126, 34,1.0)', 'rgba(127, 140, 141,1.0)'],
                        hoverBackgroundColor: 'rgba(52, 73, 94,1.0)',
                        hoverBorderColor: 'rgba(236, 240, 241,1.0)',
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
                    type: 'doughnut',
                    data: chartdata,
                    options: {
                        title: {
                            display: true,
                            text: 'Kölcsönző cégek eloszlása fő/cég-ben'
                        }
                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>