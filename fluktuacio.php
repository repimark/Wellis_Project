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
            <div class="chartsEves bg-light">
                <select class="form-control" id="honap"></select>
                <canvas id="canvEv" class="bg-light rounded shadow mb-5"></canvas>
            </div>
        </div>
        <script>
            var terulet = []
            var belepesi = []
            var kilepesi = []
            var barGraph2
            // var evesTerulet = []
            // var evesKilepes = []
            // var evesBelepes = []
            
            var honapok = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December" ]
            var honapValues = ['2021-01-15','2021-02-15','2021-03-15','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2021-08-01','2021-09-01','2021-10-01','2021-11-01','2021-12-01']

            $(document).ready(function(){

                var selectLines = []
                for(i in honapok){
                    selectLines += '<option value="' + honapValues[i] + '">' + honapok[i] + '</option>'
                }
                $('#honap').html(selectLines)
            })

            $('#honap').change(function(){
                var honapVal = $('#honap :selected').val()
                var honapText = $('#honap :selected').text()
                //alert(honapVal + ' / ' + honapText)
                getEvesFluktuacio(honapVal, honapText)
            })

            $('.container').ready(function() {
                getDolgozok()
                //getHetiFluktu()
                //getEvesFluktuacio()
                //rajzHeti(honapokVar[i], honapokAdat[i], canvas, honapokVar[i], honapok[i])
            });
            
            var getHetiFluktu = function(){
                var d = new Date()
                var today = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
                $.ajax({
                    url: 'adatok/getHetiFluktuacio.php',
                    type: 'POST',
                    cache: false,
                    data: {
                        today: today
                    },
                    success: function(res) {
                        var objJSON = JSON.parse(res);
                        for (i in objJSON) {
                            hetiTerulet.push(objJSON[i].terulet)
                            hetiBelepes.push(parseFloat(objJSON[i].be))
                            hetiKilepes.push(parseFloat(objJSON[i].ki))
                        }
                        rajzHeti()
                    }
                });
            }
            var getEvesFluktuacio = function(honap, honapText){
                var evesTerulet = []
                var evesKilepes = []
                var evesBelepes = []
                rajzHeti(evesTerulet, evesKilepes, 'canvEv', honapText)
                $.ajax({
                    url: 'php/getFluktuacio.php',
                    type: 'POST',
                    data: {
                        today: honap
                    },
                    success: function(res){
                        //alert(res)
                        var obj = JSON.parse(res)
                        for (i in obj){
                            //console.log(obj[i].terulet)
                            evesTerulet.push(obj[i].terulet)
                            evesBelepes.push(parseFloat(obj[i].be))
                            evesKilepes.push(parseFloat(obj[i].ki))
                        }       
                        rajzHeti(evesTerulet, evesKilepes, 'canvEv', honapText)                 
                    },
                    error: function(errorRes){
                        alert(errorRes)
                    }
                })
            }
            var getDolgozok = function(obj) {
                var d = new Date()
                var today = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
                $.ajax({
                    url: 'php/getFluktuacio.php',
                    type: 'POST',
                    cache: false,
                    data: {
                        today: today
                    },
                    success: function(res) {
                        //console.log(res)
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
                     datasets: [
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
                            text: 'Havi kilépési adatok %-ban'
                        }
                    }
                });
            }
            var rajzHeti = function(terulet,adat,canv, cim){

                if(barGraph2){
                    barGraph2.destroy();
                }
                
                var chartdata = {
                    
                    labels: terulet,
                    datasets: [{
                            data: adat,
                            label: cim,
                            backgroundColor: ['rgba(252, 92, 101,0.75)','rgba(253, 150, 68,0.75)','rgba(38, 222, 129,0.75)','rgba(43, 203, 186,0.75)','rgba(69, 170, 242,0.75)','rgba(75, 123, 236,0.75)','rgba(165, 94, 234,0.75)','rgba(209, 216, 224,0.75)','rgba(119, 140, 163,0.75)','rgba(254, 211, 48,0.75),rgba(235, 59, 90,0.75)','rgba(32, 191, 107,0.75)', 'rgba(75, 101, 132,0.75)'],
                            borderColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            //hoverBackgroundColor: ['rgba(252, 92, 101,1.0)','rgba(253, 150, 68,1.0)','rgba(38, 222, 129,1.0)','rgba(43, 203, 186,1.0)','rgba(69, 170, 242,1.0)','rgba(75, 123, 236,1.0)','rgba(165, 94, 234,1.0)','rgba(209, 216, 224,1.0)','rgba(119, 140, 163,1.0)','rgba(254, 211, 48,1.0),rgba(235, 59, 90,1.0)','rgba(32, 191, 107,1.0)', 'rgba(75, 101, 132,1.0)'],
                            //hoverBorderColor: 'rgba(0,0,0,1.0)',
                            borderWidth: 1
                        }
                    ],
                    options: {
                        responsive: false,
                        maintainAspectRatio: true,
                        legend: {
                            display: false,
                            position: 'top'
                        },
                        hover:{
                            intersect: false
                        }
                    }
                };
                var ctx = document.getElementById(canv).getContext('2d');
                barGraph2 = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        title: { 
                            display: true,
                            text: cim + ' havi kilépési adatok %-ban'
                        },
                        hover: {
                            intersect: false
                        }
                    }
                })
                //barGraph.reset()
            }
        </script>
    </body>

    </html>
<?php } ?>
