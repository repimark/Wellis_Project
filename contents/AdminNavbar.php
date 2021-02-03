<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../admin/loggedIn.php"><img src="../wellislogo.png"  height="25"> Igényfelmérés <span class="badge badge-danger">Admin</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Szerkesztések 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../admin/editTerulet.php">Területek kezelése</a>
          <a class="dropdown-item" href="../admin/editPozicio.php">Poziciók kezelése</a>
          <a class="dropdown-item" href="../admin/editUsers.php">Felhasználók kezelése</a>
          <a class="dropdown-item" href="../admin/editSorok.php">Sorok kezelése</a>
          <a class="dropdown-item" href="../admin/editSzeEgys.php">Szervezeti egységek szerkeztése</a>
        </div>
      </li> 
    </ul>
    <span class="badge badge-info w-25">
      <p class="navbar-text p-2 text-white"><?php echo $_SESSION["a_name"];?></p>
      <span class="navbar-text p-1"><a class="navbar-text" href="../admin/EditUser.php"><img src="../admin/media/admin.png" height="25"></a></span>
      <span class="navbar-text p-1"><a class="navbar-text" href="../admin/php/logout.php"><img src="../admin/media/exit.png" height="25"></a></span>
    </span>

    
  </div>

</nav>