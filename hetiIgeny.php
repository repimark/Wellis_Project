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
            <h2 class="text-center">Heti igények</h2>
            <div id="hetiIgenyTabla">
            <h4><span class="badge badge-dark">Aktuális hét</span></h4>
                <table id="hetiIgeny" class="rounded table table-light">
                    <thead class="thead-dark thead">
                        <tr>
                            <th>Hét száma</th>
                            <th>Belépő cél (fő)</th>
                            <th>Belépők száma (fő)</th>
                        </tr>
                    </thead> 
                    <tbody id="hetiTB">
                    </tbody>
                </table>
            </div>
            <div id="mindenHetiIgeny">
                <h4><span class="badge badge-dark">Egész éves</span></h4>
            <table id="mindenHetiIgeny" class=" rounded table bg-light table-striped">
                    <thead class="thead-dark thead">
                        <tr>
                            <th>Hét száma</th>
                            <th>Belépő cél (fő)</th>
                            <th>Belépők száma (fő)</th>
                        </tr>
                    </thead> 
                    <tbody id="evesTB">
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var d = new Date()
                var n = d.getFullYear()+'.'+(d.getMonth()+1)+'.'+d.getDate();
                getAdat(n)
                getEvesAdat(n)
            })
            var getAdat = function(today){
                $.ajax({
                    url: 'adatok/getHetiIgeny.php',
                    type: 'POST',
                    data: {
                        today: today
                    },
                    success: function(res){
                        console.log(res)
                        var obj = JSON.parse(res)
                        var line = []
                        for(i in obj){
                            if(obj[i].db >= 15){
                                line+='<tr class="bg-success"><td>' + obj[i].het + '</td><td>15</td><td>' + obj[i].db + '</td></tr>'
                            }else{
                                line+='<tr><td>' + obj[i].het + '</td><td>15</td><td>' + obj[i].db + '</td></tr>'
                            }
                        }
                        $('#hetiTB').html(line)
                    },
                    error: function(errRes){
                        console.log(errorRes)
                    }
                })
            }
            var getEvesAdat = function(today){
                $.ajax({
                    url: 'adatok/getOsszesHetiIgeny.php',
                    type: 'POST',
                    data: {
                        today: today
                    },
                    success: function(res){
                        console.log(res)
                        var obj = JSON.parse(res)
                        var line = []
                        for(i in obj){
                            if(obj[i].db >= 15){
                                line+='<tr class="bg-success"><td>' + obj[i].het + '</td><td>15</td><td>' + obj[i].db + '</td></tr>'
                            }else{
                                line+='<tr><td>' + obj[i].het + '</td><td>15</td><td>' + obj[i].db + '</td></tr>'
                            }
                        }
                        $('#evesTB').html(line)
                    },
                    error: function(errRes){
                        console.log(errorRes)
                    }
                })
            }
        </script>
    </body>

    </html>
<?php } ?>