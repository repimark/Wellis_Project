<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../Admin/loggedIn.php"><img src="../wellislogo.png"  height="25"> Igényfelmérés <span class="badge badge-danger">Admin</span></a>
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
          <a class="dropdown-item" href="../Admin/editTerulet.php">Területek kezelése</a>
          <a class="dropdown-item" href="../Admin/editPozicio.php">Poziciók kezelése</a>
          <a class="dropdown-item" href="../Admin/editUsers.php"><span class="badge badge-dannger">Felhasználók kezelése</span></a>
        </div>
      </li> 
    </ul>
    <span class="badge badge-info w-25">
      <p class="navbar-text p-2 text-white"><?php echo $_SESSION["a_name"];?></p>
      <span class="navbar-text p-1"><a class="navbar-text" href="../Admin/EditUser.php"><img src="../Admin/media/admin.png" height="25"></a></span>
      <span class="navbar-text p-1"><a class="navbar-text" href="../Admin/php/logout.php"><img src="../Admin/media/exit.png" height="25"></a></span>
    </span>

    
  </div>

</nav>