<?php
session_start();
if (!isset($_SESSION["u_id"])) {
    header("location: login.php");
} else {
    if ($_SESSION["jog"] == '3') {
        header("location: igenyPerPozi.php");
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Wellis igényfelmérés</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="icon" type="image/png" sizes="32x32" href="icons/icon-32x32.png">

        <style type="text/css">
            .card-header {
                background: #232526;
                /* fallback for old browsers */
                background: -webkit-linear-gradient(to top, #414345, #232526);
                background: linear-gradient(to top, #414345, #232526);
                color: white;

            }

            .btn-reszletek {
                background-color: #343a40;
                /* fallback for old browsers */
                /*background: -webkit-linear-gradient(to bottom, #414345, #232526);   Chrome 10-25, Safari 5.1-6 
      background: linear-gradient(to bottom, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                /*color: grey;*/
                color: rgba(255, 255, 255, .5);

            }

            .btn-reszletek:hover {
                color: rgba(255, 255, 255, .75);
            }

            .card-header h5 a {
                color: rgba(255, 255, 255, .5);
            }

            .card-header h5 a:hover {
                color: rgba(255, 255, 255, .75);
            }

            .card-body {
                background-color: #F5F5F5 !important;
            }

            .footer {
                background-color: #34495e !important;
                text-align: center !important;
                /* height:30px!important; */
                color: #bdc3c7 !important;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="style.css" />
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
            <br>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#newModal"><span class="badge badge-success">+</span> új bejegyzés létrehozása</button>
            <div class="accordion" id="felsorolasok">

            </div>

            <div class="modal" tabindex="-1" id="newModal">>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Új FAQ létrehozása</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-label-group">

                                    <input type="text" class="form-control" id="title" placeholder="Cím" />
                                    <label for="title">Cím</label>
                                </div>
                                <div class="form-label-group">
                                    <label for="#content">Szöveg</label>
                                    <textarea id="content" placeholder="Szöveg" rows="10" cols="10" class="form-control"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
                            <button type="button" class="btn btn-primary" id="addBtn">Hozzáadás</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" tabindex="-1" id="editModal">>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Bejegyzés szerkesztése</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-label-group">

                                    <input type="text" class="form-control" id="editTitle" placeholder="Cím" />
                                    <label for="editTitle">Cím</label>
                                </div>
                                <div class="form-label-group">
                                    <label for="#editContent">Szöveg</label>
                                    <textarea id="editContent" placeholder="Szöveg" rows="10" cols="10" class="form-control"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
                            <button type="button" class="btn btn-primary" id="editBtn">Módosítás</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                getFaq()
            })
            var getFaq = function() {
                var lines = []
                $.ajax({
                    url: 'faq/getFaq.php',
                    type: 'GET',
                    success: function(res) {
                        var obj = JSON.parse(res)
                        for (i in obj) {
                            lines += '<div class="card">'
                            lines += '<div class="card-header" id="heading' + obj[i].id + '">'
                            lines += '<h2 class="mb-0">'
                            lines += '<button class="btn btn-link btn-block text-left" style="text-decoration:none; color: white" type="button" data-toggle="collapse" data-target="#collapse' + obj[i].id + '" aria-expanded="true" aria-controls="collapse' + obj[i].id + '">'
                            lines += '<span id="cbt' + obj[i].id + '">' + obj[i].cim + '</span>'
                            lines += '</button>'
                            lines += '</h2>'
                            lines += '</div>'
                            lines += '<div id="collapse' + obj[i].id + '" class="collapse" aria-labelledby="heading' + obj[i].id + '" data-parent="#felsorolasok">'
                            lines += '<div class="card-body">'
                            lines += '<p id="cbc' + obj[i].id + '">' + obj[i].szoveg + '</p>'
                            lines += '<hr/>'
                            lines += '<button class="btn btn-danger float-right" style="height:30px;margin:auto;padding:2px;" onclick="deleteFaq(' + obj[i].id + ')">Törlés</button>'
                            lines += '<button class="btn btn-info float-right" style="height:30px;margin:auto;padding:2px;" onclick="editFaq(' + obj[i].id + ')">Szerkesztés</button>'
                            lines += '</div>'
                            lines += '</div>'
                            lines += '</div>'
                        }
                        $('#felsorolasok').html(lines)
                    }
                })
            };
            $('#addBtn').click(function() {
                var cim = $('#title').val()
                var szoveg = $('#content').val()
                $.ajax({
                    url: 'faq/addFaq.php',
                    type: 'POST',
                    data: {
                        cim: cim,
                        szov: szoveg
                    },
                    success: function(res) {
                        //alert(res)
                        $('#title').val('')
                        $('#content').val('')
                        $('#newModal').modal('hide')
                        getFaq()
                    },
                    error: function(errRes) {
                        alert(errRes)
                    }
                })
            });
            var deleteFaq = function(id) {
                $.ajax({
                    url: 'faq/deleteFaq.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        if (res == "Sikeres") {
                            getFaq()
                        }
                    },
                    error: function(errRes) {
                        alert(errRes)
                    }
                });
            }
            $('#content').keypress(function(e) {
                var key = e.which;
                if (key == 13) // the enter key code
                {
                    var szov = $('#content').val()
                    szov += '<br/>'
                    $('#content').val(szov)
                }
            });
            $('#editContent').keypress(function(e) {
                var key = e.which;
                if (key == 13) // the enter key code
                {
                    var szov = $('#editContent').val()
                    szov += '<br/>'
                    $('#editContent').val(szov)
                }
            });
            var editFaq = function(id){
                var title = $('#cbt'+id).text()
                var content = $('#cbc'+id).text()
                //alert(title + ' , ' + content)
                $('#editBtn').attr('data-id',id)
                $('#editModal').modal('show')
                $('#editTitle').val(title)
                $('#editContent').val(content)
            }
            $('#editBtn').click(function() {
                var cim = $('#editTitle').val()
                var szoveg = $('#editContent').val()
                var id = $('#editBtn').data('id')
                //alert(cim + ' , ' + szoveg + ' , ' + id)
                $.ajax({
                    url: 'faq/editFaq.php',
                    type: 'POST',
                    data: {
                        id: id,
                        cim: cim,
                        szov: szoveg
                    },
                    success: function(res) {
                        //alert(res)
                        $('#editTitle').val('')
                        $('#editContent').val('')
                        $('#editModal').modal('hide')
                        getFaq()
                    },
                    error: function(errRes) {
                        alert(errRes)
                    }
                })
            });
        </script>
    </body>

    </html>
<?php } ?>