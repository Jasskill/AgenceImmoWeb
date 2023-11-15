<?php
class vue{
    public function entete(){
        echo '
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
            <title>Document</title>
        </head>
        <body>
        <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Agence Immo Web</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li>
              </ul>
              <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            </div>
          </div>
        </div>
      </nav>';
    }
    //Affichage connexion utilisateur
    public function connexion ($message = null){
      if($message !=null){
        echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
      }
      echo "
        <form method='POST' action='index.php?action=connexion'>
          <h1>Se connecter : </h1>
          <br/>
          <div class='form-group'>
            <label for='mail'> Adresse email </label>
            <input type='mail' name='mail' class='form-control' id='email' placeholder='votrepseudo@gmail.com' required>
          </div>
          <div class='form-group'>
            <label for='motdepasse'> Mot de passe </label>
            <input type='password' name='motdepasse' class='form-control' id='motdepasse' placeholder='●●●●●●●' required>
          </div>
          <br/>
          <a href='index.php?action=inscription'> Vous n'êtes pas encore inscrit? Inscrivez-vous ! </a>
          <br/>
          <br/>
          <button type='submit' class='btn btn-primary' name='buttonconnect'>Connexion</button>
        </form>
      ";
      $this->fin();
    }
    //Affichage inscription utilisateur
    public function inscription($message = null){
      if($message !=null){
        echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
      }
      echo "
        <form method='POST' action='index.php?action=inscription'>
          <h1>S'inscrire : </h1>
          <br/>
          <div class='form-group'>
            <label for='nom'>Votre nom</label>
            <input type='text' name='nom' class='form-control' id='nom' required>
          </div>
          <div class='form-group'>
            <label for='prenom'>Votre prénom</label>
            <input type='text' name='prenom' class='form-control' id='prenom' required>
          </div>
          <div class='form-group'>
            <label for='nom'>Votre mail</label>
            <input type='text' name='mail' class='form-control' id='mail'  placeholder='votrepseudo@gmail.com' required>
          </div>
          <div class='form-group'>
            <label for='mdp'>Mot de passe</label>
            <input type='text' name='mdp' class='form-control' id='mdp'  placeholder='●●●●●●' required>
          </div>
          <div class='form-group'>
            <label for='mdp2'>Confirmer votre mot de passe/label>
            <input type='text' name='mdp2' class='form-control' id='mdp2' placeholder='●●●●●●' required>
          </div>
          <br/>
          <a href='index.php?action=connexion'>Vous êtes déjà client ? Connectez-vous !</a>
          <br/>
          <br/>
          <button type'submit' class='btn btn-primary' name='buttonregister'>Inscription</button>
        </form>
      "; 
      $this->fin();     
    }
    public function fin(){
        echo "
        </body>
        </html>"
    }
}
?>