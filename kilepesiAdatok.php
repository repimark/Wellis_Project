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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            <div id="kilepesiadatok">
                <div class="form-group w-50 p-2 m-2 bg-light rounded">
                    <h3 class="text-center">Év kiválasztása</h3>
                    <hr />
                    <label for="#ev">Év: </label>
                    <!-- <input type="text" id="ev" class="form-control" placeholder="2020" /> -->
                    <select id="ev" class="form-control">
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                    <br />
                    <!-- <button class="btn btn-primary form-control" id="kilepettekBtn">Lekérdezés</button> -->
                </div>
                <div id="kilepesResult" class="bg-light m-2 p-2 rounded">

                </div>
                <div id="chart_div" class="m-2 rounded"></div>
            </div>
        </div>
        <script>
            $('#ev').change(function() {
                var year = $('#ev :selected').val()

                load_monthwise_data(year, 'évi havi kilépők számának kimutatása')
                getAtlag()
            });

            google.charts.load('current', {
                packages: ['corechart', 'bar']
            });

            google.charts.setOnLoadCallback();

            function load_monthwise_data(year, title) {
                var temp_title = year + ' ' + title + '';
                $.ajax({
                    url: "adatok/getAtlagosanKilepett.php",
                    method: "POST",
                    data: {
                        year: year
                    },
                    dataType: "JSON",
                    success: function(data) {
                        drawMonthwiseChart(data, temp_title);
                    }
                });
            }

            function drawMonthwiseChart(chart_data, chart_main_title) {
                var jsonData = chart_data;
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Hónap');
                data.addColumn('number', 'Létszám');
                $.each(jsonData, function(i, jsonData) {
                    var month = jsonData.honap;
                    var profit = parseFloat($.trim(jsonData.adat));
                    data.addRows([
                        [month, profit]
                    ]);
                });
                var options = {
                    title: chart_main_title,
                    hAxis: {
                        title: "Hónap"
                    },
                    vAxis: {
                        title: 'Létszám'
                    },
                    //is3D: true,
                    width: 600,
                    height: 400
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
            var getAtlag = function() {
                var evIn = $('#ev').val()
                $.ajax({
                    url: 'adatok/getAtlagosanKilepett.php',
                    type: 'POST',
                    data: {
                        year: evIn
                    },
                    success: function(Result) {
                        console.log(Result)
                        var obj = JSON.parse(Result)
                        var lines = [];
                        var osszKilepett = parseInt(0)
                        for (var i = 0; i <= obj.length - 1; i++) {
                            osszKilepett += parseInt(obj[i].adat)
                        }
                        var atlag = osszKilepett / 12
                        $('#kilepesResult').html('<h2>' + evIn + '-ban összesen ' + osszKilepett + ' dolgozó lépett ki, ami átlagban ' + atlag + ' dolgozó havonta. </h2>')

                    }
                });
            }
        </script>
    </body>

    </html>
<?php } ?>