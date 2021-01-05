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
          <a class="dropdown-item" href="addUser.php">Dogozók hozzáadása</a>
          <a class="dropdown-item" href="kilepett.php">Kiléptetett Dolgozók</a>
          <a class="dropdown-item" href="osszesito.php">Összesítő</a>
          <a class="dropdown-item" href=""><span class="badge badge-danger">Ózd</span></a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Adatok vizualizálva
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Kilépési adatok</a>
          <a class="dropdown-item" href="#">Mikor jött / Mikor ment ?</a>
          <a class="dropdown-item" href="#">Igény Változások</a>
          <a class="dropdown-item" href="#"></a>
        </div>

    </ul>
    <span class="navbar-text p-1"><?php echo $_SESSION["u_name"]; ?> <a href="php/logout.php">Kijelentkezés</a></span>
  </div>
</nav>