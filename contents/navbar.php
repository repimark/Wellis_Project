<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php"><img src="wellislogo.png" height="25"> Igényfelmérés</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dolgozók kezelése
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="users.php">Dolgozók szerkesztése</a>
         
          <a class="dropdown-item" href="kilepett.php">Kiléptetett Dolgozók</a>
          <a class="dropdown-item" href="osszesito.php">Összesítő</a>
          <a class="dropdown-item" href="hetiIgeny.php">Igény teljesítések</a>
          <a class="dropdown-item" href="szellemi.php">Szellemi keresések</a>
          <a class="dropdown-item" href="igenyPerPozi.php">Poziciónkénti igények</a>
          <a class="dropdown-item" href="http://ozdwellis.repitsmark.xyz"><span class="badge badge-danger">Ózd</span></a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Adatok vizualizálva
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- <a class="dropdown-item" href="kilepesiAdatok.php">Kilépési adatok</a> -->
          <a class="dropdown-item" href="meddigMaradt.php">Átlagos maradási idő</a>
          <a class="dropdown-item" href="igenyValtozasok.php">Igény Változások</a>
          <a class="dropdown-item" href="haviDolgozok.php">Fluktuáció és ép� fő-ben (havi)</a>
          <a class="dropdown-item" href="kolcsonzok.php">Kölcsönzőcégek megoszlása</a>
          <a class="dropdown-item" href="fluktuacio.php">Fluktuácó és belépés  %-ba (havi / heti)</a>
        </div>
      </li>
    </ul>
    <input id="search" class="rounded mr-sm-2" width="100" aria-label="Keresés" type="search" placeholder="Keresés"/>
    <span class="navbar-text p-1"><?php echo $_SESSION["u_name"]; ?> <a href="php/logout.php">Kijelentkezés</a></span>
  </div>
</nav>
<div class="alert alert-dark" id="alert" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div id="valasz"></div>
</div>
<script>
  $(document).ready(function(){
    $('#alert').hide()
  });
  $('#search').change(function(){
    var nev = $('#search').val()
    $.ajax({
      url: '../php/search.php',
      type: 'POST',
      data: {
        nev: nev
      },
      success: function(Result){
        //alert(Result)
        $('#valasz').html(Result)
        $('#alert').show()
        
        
      },
      error: function(errorData){
        alert(errorData)
      }
    });
  });
</script>
