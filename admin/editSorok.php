<?php
session_start();
if (!isset($_SESSION["a_id"])) {
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

        <?php
        include '../contents/links.php';
        ?>
    </head>

    <body>
        <?php
        include("../contents/AdminNavbar.php");
        ?>
        <div class="container">
            <h1 class="text-center p-5">Sorok Kezelése </h1>

            <div class="subcont w-50 bg-light p-2 m-2">
                <h2 class="text-center"> Sorok Hozzáadása </h2>
                
                    <div class="form-group">
                        <label for="#elnevezes" class="form-label">Sor név: </label>
                        <input class="form-control" type="text" id="elnevezes" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" id="do_it">Sor hozzáadása</button>
                    </div>
                

            </div>
            <div class="subcont w-50 p-2 m-2 bg-light">
                <h2 class="text-center">Sorok Listázása</h2>
                <div id="sorok-table" class="border"></div>
            </div>
            <div class="subcont w-50 p-2 m-2 bg-light">
                <h2 class="text-center">Sorok Törlése</h2>
                
                    <div class="form-group">
                        <label for="#selectSor">Sor kiválasztása</label>
                        <select id="selectSor" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <button id="delSorBtn" class="btn btn-danger">Törlés</button>
                    </div>
                
            </div>
        </div>
        <script>
            $('.container').ready(function() {
                getSorok()
            });

            var getSorok = function() {
                $.ajax({
                    url: '../php/getSor.php',
                    type: 'POST',
                    cache: false,
                    success: function(Result) {
                        var obj = JSON.parse(Result);
                        var lines = [];
                        lines += '<table class="table bg-light">'
                        lines += '<thead class="thead-dark">'
                        lines += '<tr><th>Sor Név:</th></tr>'
                        lines += '</thead>'
                        lines += '<tbody>'
                        if (obj.length > 0) {
                            for (var i = obj.length - 1; i >= 0; i--) {
                                lines += '<tr><td data-id="' + obj[i].id + '">' + obj[i].elnev + '</td></tr>'
                            }
                        } else {
                            lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
                        }
                        lines += '</tbody>'
                        lines += '</tables>'
                        $('#sorok-table').html(lines)
                    }
                });
                $.ajax({
                    url: '../php/getSor.php',
                    type: 'POST',
                    cache: false,
                    success: function(Results) {
                        var obj = JSON.parse(Results);
                        var lines = [];
                        if (obj.length > 0) {
                            for (var i = obj.length - 1; i >= 0; i--) {
                                lines += '<option data-id="' + obj[i].id + '">' + obj[i].elnev + '</option>'
                            }
                        } else {
                            lines += 'Nincs még hozzárendelve pozicíó ehhez a területhez'
                        }
                        $('#selectSor').html(lines)
                    }
                });
            };


            $('#delSorBtn').click(function() {
                var sorId = $('#selectSor :selected').data('id')
                $.ajax({
                    url: 'php/deleteSor.php',
                    type: 'GET',
                    cache: false,
                    data: {
                        s_id: sorId
                    },
                    success: function(Result) {
                        //console.log(Result)
                        location.reload()
                    }
                });
            });

            $('#do_it').click(function() {
                addSorok()
            });

            var addSorok = function() {
                var elnev = $('#elnevezes').val()
                $.ajax({
                    url: '../php/addSorok.php',
                    type: 'POST',
                    cache: false,
                    data: {
                        sElnev: elnev
                    },
                    success: function(res) {
                        ////console.log(res)
                        //$('#sorok-table').text(res)
                        location.reload()
                    }
                });
            };
        </script>
    </body>

    </html>
<?php } ?>