<?php
class Vue {
    public function entete() {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <title>Document</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                            <div class="container">
                                <a class="navbar-brand" href="index.php">Agence Immo Web</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav ms-auto">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?action=annonce">Annonces</a>
                                        </li>';
                    // Condition pour afficher le bouton Connexion/Déconnexion
                    if (isset($_SESSION['estconnecte'])) {
                        echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?action=logout">Déconnexion</a>
                                        </li>';
                    } else {
                        echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?action=connexion">Connexion</a>
                                        </li>';
                    }

                echo '
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?action=inscription&id=1">Inscription</a>
                                        </li>
                                    </ul>
                                    <form class="d-flex" role="search">
                                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </form>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>';
    }

    public function accueil() {
        $this->entete();
        $lesAnnonces = (new Annonce)->recupererAnnonce(0, 5);
        for($i=0;$i<5;$i++){
        echo '
                <div class="row">';
        foreach ($lesAnnonces as $annonce) {
            echo '
                    <div class="col">' .
                        $annonce["id"] . " ; " . $annonce["rue"] . '
                    </div>';
        }
        echo '
                </div>';
        }
        $this->fin();
      
    }
  // Deconnexion utilisateur
  public function deconnexion ($message = null){
    $this->entete();
    session_destroy();
  }
  //Affichage connexion utilisateur
  public function connexion ($message = null){
    if (!isset($_SESSION)) {
      session_start();
  }
  $this->entete();
  if($message !=null){
    echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
    }
    echo "
      <div class='d-flex justify-content-center'>
        <form method='POST' action='index.php?action=connexion'>
          <h1>Se connecter : </h1>
          <br/>
          <div class='form-group'>
            <label for='mail'> Adresse email </label>
            <input type='mail' name='mail' class='form-control' id='email' placeholder='votrepseudo@gmail.com' required>
          </div>
          <div class='form-group'>
            <label for='motdepasse'> Mot de passe </label>
            <input type='password' name='mdp' class='form-control' id='motdepasse' placeholder='●●●●●●●' required>
          </div>
          <br/>
          <a href='index.php?action=inscription'> Vous n'êtes pas encore inscrit? Inscrivez-vous ! </a>
          <br/>
          <br/>
          <button type='submit' class='btn btn-secondary' name='buttonconnect'>Connexion</button>
        </form>
      </div>
    ";
    $this->fin();
  }
  //Affichage inscription utilisateur
  public function inscription($message = null){
    $this->entete();
    if($message !=null){
      echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
    }
    echo "
      <div class='d-flex justify-content-center'>
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
            <input type='password' name='mdp' class='form-control' id='mdp'  placeholder='●●●●●●' required>
          </div>
          <div class='form-group'>
            <label for='mdp2'>Confirmer votre mot de passe</label>
            <input type='password' name='mdp2' class='form-control' id='mdp2' placeholder='●●●●●●' required>
          </div>
          <br/>
          <a href='index.php?action=connexion'>Vous êtes déjà client ? Connectez-vous !</a>
          <br/>
          <br/>
          <button type'submit' class='btn btn-secondary' name='buttonregister'>Inscription</button>
        </form>
      </div>
    "; 
    $this->fin();     
  }
  public function fin(){
    echo "
            </div>
        </body>
        </html>";
  }
  public function erreur404(){
    http_response_code(404);
    $this->entete();

    echo "
      <h1>Erreur 404 : page introuvable !</h1>
      <br/>
      <p>
        Cette page n'existe pas ou a été supprimée !
      </p>
    ";
  
    $this->fin();
  }
}
?>