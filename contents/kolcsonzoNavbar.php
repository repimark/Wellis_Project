<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="igenyPerPozi.php"><img src="wellislogo.png" height="25"> Igényfelmérés <span class="badge badge-danger">Kölcsönző </span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menü
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <a class="dropdown-item" href="igenyPerPozi.php">Poziciónkénti igények</a>
                    
                </div>
            </li>
            
        </ul>
        
        <span class="navbar-text p-1"><?php echo $_SESSION["u_name"]; ?> <a href="php/logout.php">Kijelentkezés</a></span>
    </div>
</nav>
