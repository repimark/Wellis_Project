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
            <h1> Igeny valtozasok </h1>
            <canvas id="canv1"></canvas>
            <canvas id="canv2"></canvas>
        </div>
        <script>
            var minus = [];
            var minusLabel = [];
            var plus = [];
            var plusLabel = [];
            $(document).ready(function(){
                var today = new Date()
                var year = today.getFullYear();
                var month = today.getMonth() + 1;
                getValtozasAHonapban(year, month)
                rajz(minusLabel, minus, 'canv1', '-')
                rajz(plusLabel, plus, 'canv2', '+')
            });
            var getValtozasAHonapban = function(year,month){
                $.ajax({
                    url: 'adatok/getIgenyValtozas.php',
                    type: 'GET',
                    data: {
                        year: year,
                        month: month
                    },
                    success: function(Data){
                        console.log(Data)
                        var obj = JSON.parse(Data);
                        for (i in obj){
                            //console.log(obj[i].muvelet)
                            
                            if(obj[i].muvelet == "-" ){
                                //console.log(obj[i].muv)
                                minus.push(obj[i].db)
                                minusLabel.push(obj[i].pozi)
                            }else{
                                console.log(obj[i].muvelet)
                                plus.push(obj[i].db)
                                plusLabel.push(obj[i].pozi)
                            }
                        }
                    },
                    error: function(errorData){
                        console.log(errorData)
                    }
                });
            }
            var rajz = function(labels, datas, dest, muv){
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
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                    position: 'top'
                                }
                            }
                        };
                        var ctx = document.getElementById(dest).getContext('2d');
                        var barGraph = new Chart(ctx, {
                            type: 'bar',
                            data: chartdata
                        });
            }
            
        </script>
    </body>
    </html>
<?php } ?>