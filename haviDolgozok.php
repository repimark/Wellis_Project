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
        require('connect.php');
        ?>
        <div class="container">
            <h2 class="text-center">Be- és Kilépett Dolgozók</h2>
            <div id="chart_cont">
                <br/>
                <canvas id="canv3" class="bg-light rounded shadow mb-5"></canvas>
                <br/>
                <canvas id="canv4" class="bg-light rounded shadow mb-5"></canvas>
                <br/>
            </div>
        </div>
        <script type="text/javascript">
            var teruletLabel = []
            var belepett = []
            var kilepett = []
            var hetiBelepett = []
            var hetiKilepett = []
            var hetiTerulet = []
            $('.container').ready(function() {
                var datum = new Date()
                var y = datum.getFullYear()
                var m = datum.getMonth() + 1
                var n = datum.getFullYear()+'.'+(datum.getMonth()+1)+'.'+datum.getDate();
                //loadDolgozok(y, m)
                loadHavi(n)
                loadHeti(n)
                
            });
            var loadHavi = function(today) {
                $.ajax({
                    url: "adatok/getHaviValtozas.php",
                    method: "POST",
                    data: {
                        today: today
                    },
                    success: function(data) {
                        //console.log(data)
                        var obj = JSON.parse(data)
                        for (i in obj) {
                            //teruletLabel.push(data[i].terulet)
                            //adat.push(obj[i].db)
                            teruletLabel.push(obj[i].terulet)
                            belepett.push(parseInt(obj[i].belep))
                            kilepett.push(parseInt(obj[i].kilep))
                            
                        }
                        hetiRajz(teruletLabel, kilepett, belepett, 'canv3', 'bar', 'Havi Kilépett Dolgozók', 'Havi Belépett Dolgozók', 'Havi Munkaerő változások (fő)')
                    },
                    error: function(error) {
                        //console.log(error)
                    }
                });
            }
            var loadHeti = function(today){
                $.ajax({
                    url: 'adatok/getHetiValtozas.php',
                    type: 'POST',
                    data: {
                        today: today,
                    },
                    success: function(res){
                        var obj = JSON.parse(res)
                        for (i in obj) {
                            hetiBelepett.push(obj[i].belep)
                            hetiKilepett.push(obj[i].kilep)
                            hetiTerulet.push(obj[i].terulet)
                        }
                        hetiRajz(hetiTerulet, hetiKilepett, hetiBelepett, 'canv4','bar', 'Heti Kilépett Dolgozók', 'Heti Belépett Dolgozók', 'Heti Munkaerő változások (fő)')
                    },
                    error: function(errorData){
                        console.log(errorData)
                    }
                });
            }
            
            var hetiRajz = function(label, kilep, belep, canv ,typ, cim1, cim2 ,foCim){
                var chartdata = {
                    labels: label,
                    datasets: [{
                            data: kilep,
                            label: cim1,
                            backgroundColor: 'rgba(255, 118, 117,1.0)',
                            borderColor: 'rgba(255, 118, 117,1.0)',
                            hoverBackgroundColor: 'rgba(200,200,200,1.0)',
                            hoverBorderColor: 'rgba(200,200,200,1.0)',
                            borderWidth: 1
                        },
                        {
                            data: belep,
                            label: cim2,
                            backgroundColor: 'rgba(0, 184, 148,1.0)',
                            borderColor: 'rgba(0,184,148,1.0)',
                            hoverBackgroundColor: 'rgba(0,184,148,1.0)',
                            hoverBorderColor: 'rgba(0,184,148,1.0)',
                            borderWidth: 1
                        }
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
                var ctx = document.getElementById(canv).getContext('2d');
                var barGraph = new Chart(ctx, {
                    type: typ,
                    data: chartdata,
                    options: {
                        title: {
                            display: true,
                            text: foCim
                        }
                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>