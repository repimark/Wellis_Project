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
            <div class="changeHonap">
                <select id="dateSelector" class="form-control"></select>
            </div>
            <h2 class="text-center brand"> Igény változások </h2>
            <canvas id="canv2" class="bg-light rounded shadow mb-5"></canvas>
            <canvas id="canv1" class="bg-light rounded shadow mb-5"></canvas>
        </div>
        <script>
            var minus = [];
            var minusLabel = [];
            var plus = [];
            var plusLabel = [];
            var honapok = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December" ]
            var honapValues = ['2021-01-15','2021-02-15','2021-03-15','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2021-08-01','2021-09-01','2021-10-01','2021-11-01','2021-12-01']
            $(document).ready(function() {
                var honapokVal = []
                for (i in honapok){
                    honapokVal += '<option value="' + honapValues[i] + '">' + honapok[i] + '</option>'
                }
                $('#dateSelector').html(honapokVal)
                var d = new Date()
                var day = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
                getValtozasAHonapban(day)
                rajz(minusLabel, minus, 'canv1', '-')
                rajz(plusLabel, plus, 'canv2', '+')
            });
            $('#dateSelector').change(function(){
                var dateV = $('#dateSelector').val()
                getValtozasAHonapban(dateV)
            })
            var getValtozasAHonapban = function(today) {
                $.ajax({
                    url: 'adatok/getIgenyValtozas.php',
                    type: 'GET',
                    data: {
                        today: today
                    },
                    success: function(Data) {
                        //console.log(Data)
                        alert(Data)
                        var obj = JSON.parse(Data);
                        for (i in obj) {
                            ////console.log(obj[i].muvelet)

                            if (obj[i].muvelet == "-") {
                                ////console.log(obj[i].muv)
                                minus.push(obj[i].db)
                                minusLabel.push(obj[i].pozi)
                            } else {
                                //console.log(obj[i].muvelet)
                                plus.push(obj[i].db)
                                plusLabel.push(obj[i].pozi)
                            }
                        }
                    },
                    error: function(errorData) {
                        //console.log(errorData)
                    }
                });
            }
            var rajz = function(labels, datas, dest, muv) {
                var chartdata = {
                    labels: labels,
                    datasets: [{
                        data: datas,
                        label: 'Igényváltozás ' + muv,
                        backgroundColor: 'rgba(255, 118, 117,1.0)',
                        borderColor: 'rgba(255, 118, 117,1.0)',
                        hoverBackgroundColor: 'rgba(200,200,200,1.0)',
                        hoverBorderColor: 'rgba(200,200,200,1.0)',
                        borderWidth: 1
                    }],
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        legend: {
                            display: false,
                            position: 'top'
                        }
                    }
                };
                var ctx = document.getElementById(dest); //.getContext('2d');
                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata
                });
            }
        </script>
    </body>

    </html>
<?php } ?>
