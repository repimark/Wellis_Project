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
        ?>
        <div class="container">
            <br>
            <h2 class="text-center "> Szellemi Keresések</h2>
            <br>
            <button id="newKer" class="btn btn-dark" data-toggle="modal" data-target="#addModal"><span class="badge badge-success">+</span> Új keresés hozzáadása</button> 
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Aktív keresések
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <!-- Ide kerülnek az aktív keresések -->
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Szervezeti Egység</th>
                                        <th>Pozicíó</th>
                                        <th>Keresés kezdete</th>
                                        <th>Keresés határideje (45 nap)</th>
                                        <th>Keresés lezárása (dátum)</th>
                                        <th>Eltelt idő (nap)</th>
                                        <th>Eredmény</th>
                                        <th>Műveletek</th>
                                    </tr>
                                </thead>
                                <tbody id="aktiv">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Kész keresések
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <!-- Ide kerülnek a kész keresések -->
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Szervezeti Egység</th>
                                        <th>Pozicíó</th>
                                        <th>Keresés kezdete</th>
                                        <th>Keresés határideje (45 nap)</th>
                                        <th>Keresés lezárása (dátum)</th>
                                        <th>Eltelt idő (nap)</th>
                                        <th>Eredmény</th>
                                    </tr>
                                </thead>
                                <tbody id="kesz">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Lejárt keresések
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <!-- Ide kerülnek a lejárt keresések -->
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Szervezeti Egység</th>
                                        <th>Pozicíó</th>
                                        <th>Keresés kezdete</th>
                                        <th>Keresés határideje (45 nap)</th>
                                        <th>Keresés lezárása (dátum)</th>
                                        <th>Eltelt idő (nap)</th>
                                        <th>Eredmény</th>
                                    </tr>
                                </thead>
                                <tbody id="lejart">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HOZZÁADÁS MODAL -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Új keresés hozzáadása</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="#terulet">Szervezeti egység:</label>
                                <select id="terulet" class="form-control" require></select>
                                <label for="#pozicio">Pozició: </label>
                                <input type="text" class="form-control" id="pozicio" require/>
                                <label for="kezdDatum">Kezdési dátum</label>
                                <input type="date" class="form-control" id="kezdDatum" require>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
                            <button type="button" class="btn btn-primary" id="newKereses">Létrehozás</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                loadKereses()
                
            });
            $('#addModal').on('show.bs.modal', function(){
                loadTerulet()
            });
            var loadTerulet = function(){
                $.ajax({
                    url: 'szellemi/getTerulet.php',
                    type: 'POST',
                    data: {},
                    success: function(res){
                        var terulet = []
                        var obj = JSON.parse(res)
                        for( i in obj){
                            terulet += '<option data-id="' + obj[i].t_id + '">' + obj[i].terulet + '</option>'
                        }
                        $('#terulet').html(terulet)
                    },
                    error: function(errorRes){
                        console.log(errorRes)
                    }
                });
            }
            $('#newKereses').click(function(){
                var d = $('#kezdDatum').val()
                var p = $('#pozicio').val()
                var t = $('#terulet :selected').data('id')

                    addKereses(t, p, d)

            });
            var addKereses = function(ter, pozi, datum){
                $.ajax({
                    url: 'szellemi/addKereses.php',
                    type: 'POST',
                    data: {
                        terulet: ter,
                        pozi: pozi,
                        kDatum: datum
                    },
                    success: function(res){
                        location.reload()
                    },
                    error: function(errorRes){

                    }
                });
            }
            var loadKereses = function() {
                var aktiv = []
                var kesz = []
                var lejart = []
                $.ajax({
                    url: 'szellemi/getSzellemi.php',
                    type: 'POST',
                    data: {

                    },
                    success: function(res) {
                        var obj = JSON.parse(res)

                        for (i in obj) {
                            if (parseInt(obj[i].allapot) == 0) {
                                if(hatarIdoDatum(obj[i].kezdDatum) > 45){
                                    var d = new Date()
                                    var today = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
                                    lejartraJelent(obj[i].k_id, today)
                                }else{
                                aktiv += '<tr><td>' + obj[i].terulet + '</td><td>' + obj[i].pozicio + '</td><td>' + obj[i].kezdDatum + '</td><td>' + '45' + '</td><td>' + obj[i].keszDatum + '</td><td>' + hatarIdoDatum(obj[i].kezdDatum) + '</td><td>' + 'Aktív' + '</td><td>' + '<button type="button" class="keszVege btn btn-success" onClick="keszreJelent('+obj[i].k_id+')" data-id="' + obj[i].k_id + '">Készre jelent</button>' + '</td></tr>'
                                }
                            } else if (parseInt(obj[i].allapot) == 1) {
                                kesz += '<tr class="bg-success"><td>' + obj[i].terulet + '</td><td>' + obj[i].pozicio + '</td><td>' + obj[i].kezdDatum + '</td><td>' + '45' + '</td><td>' + obj[i].keszDatum + '</td><td>' + elteltIdo(obj[i].kezdDatum, obj[i].keszDatum) + '</td><td>' + 'Sikeres' + '</td></tr>'
                            } else {
                                lejart += '<tr class="bg-danger"><td>' + obj[i].terulet + '</td><td>' + obj[i].pozicio + '</td><td>' + obj[i].kezdDatum + '</td><td>' + '45' + '</td><td>' + obj[i].keszDatum + '</td><td>' + hatarIdoDatum(obj[i].kezdDatum) + '</td><td>' + 'Aktív' + '</td></tr>'
                            }
                        }
                        $('#aktiv').html(aktiv)
                        $('#kesz').html(kesz)
                        $('#lejart').html(lejart)
                    }
                });
            }
            var lejartraJelent = function(id, datum){
                $.ajax({
                    url: 'szellemi/lejartKereses.php',
                    type: 'POST',
                    data: {
                        id : id,
                        datum : datum
                    },
                    success: function(res){
                        console.log(res)
                        location.reload();
                    },
                    error: function(errorRes){
                        console.log(errorRes)
                    }
                })
            }
            $('.keszVege').click(function(){
                alert('megnyomva')
                var button = $(this)
                var id = button.data('id')
                console.log(id)
            })
            $('.keszVege').on('click', function(){
                alert('.')
            })
            var keszreJelent = function(id){
                //alert('megy ' + id )
                var d = new Date()
                var today = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate()
                $.ajax({
                    url: 'szellemi/keresesKesz.php',
                    type: 'POST',
                    data: {
                        id : id,
                        datum: today
                    },
                    success: function(res){
                        location.reload()
                    },
                    error: function(errorRes){
                        console.log(res)
                    }
                })
            }
            var hatarIdoDatum = function(kezdes) {
                var d = new Date(kezdes)
                //console.log(d.getFullYear() + '.' + (d.getMonth()+1)+'.'+d.getDate())
                d.setDate(d.getDate() + 45)
                var today = new Date()
                var tod = (today.getFullYear() + '.' + (today.getMonth() + 1) + '.' + today.getDate())
                var vege = (d.getFullYear() + '.' + (d.getMonth() + 1) + '.' + d.getDate())
                return (45 - (elteltIdo(tod, vege)))
            }
            var hatralevoIdo = function(kezdes) {
                var d = new Date(kezdes)
                var n = new Date()
                n.setDate(d.getDate() + 45)
                var diff = new Date(n - d)
                var day = diff / 1000 / 60 / 60 / 24
                return day
            }
            var elteltIdo = function(kezd, vege) {
                var start = new Date(kezd)
                var end = new Date(vege)
                var diff = new Date(end - start)
                var days = diff / 1000 / 60 / 60 / 24
                return days
            }
        </script>
    </body>

    </html>
<?php } ?>