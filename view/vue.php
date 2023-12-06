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
            <link href="css/bootstrap.css" rel="stylesheet">
            <style>
                body {
                    background-image: url("view/image-4o0ualio.png"); 
                    background-repeat: repeat;
                }
                .text-noir {
                  color: black; /* Changez la couleur selon vos préférences */
                }
            </style>
            <title>Document</title>
        </head>
        <body>
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
              <a class="navbar-brand" href="index.php">Agence Immo Web</a>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?action=annonce">Annonces</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?action=recherche">Rechercher</a>
                  </li>';
                  // Condition pour afficher le bouton Connexion/Déconnexion
                  if(isset($_SESSION['Proprietaire_session'])) {
                    echo '
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown button
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">ICI JE SUIS PROPRIO</a></li>
                        <li><a class="dropdown-item" href="index.php?action=reservation">Voir vos reservations</li>
                        <li><a class="dropdown-item" href="index.php?action=logout">Déconnexion</a></li>
                      </ul>
                    </div>';
                  } elseif(isset($_SESSION['Client_session'])){
                    echo '
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown button
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">ICI JE SUIS IENCLI</a></li>
                        <li><a class="dropdown-item" href="index.php?action=reservation">Voir vos reservations</li>
                        <li><a class="dropdown-item" href="index.php?action=logout">Déconnexion</a></li>
                      </ul>
                    </div>';
                  }
                  else{
                    echo '
                      <li class="nav-item">
                        <a class="nav-link" href="index.php?action=inscription&id=1">Inscription</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="index.php?action=connexion">Connexion</a>
                      </li>';
                  }
                  echo '
                </ul>
              </div>
            </div>
          </nav>';
  }
  

  public function accueil($lesAnnonces, $message = null) {
    $this->entete();
    if($message != null) {
      echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
    }
    echo '
              <div class="container d-flex justify-content-center main-content">
                <div class="container-fluid bg-transparent my-4 p-3" style="position: relative;">
                  <div class="row">';
    foreach($lesAnnonces as $annonce) {
      echo '
                        <div class="col-md-4 mb-4">
                          <div class="card carte">
                            <div class="card-body">
                              <h5 class="card-text">'.$annonce["description"].'</h5>
                              <h6 class="card-text">'.$annonce["codePostal"]." ".$annonce["ville"].'</h6>
                              <img class="card-img" src="./images/'.$annonce["lienPhoto"].'">
                            </div>
                            <li class="list-group-item">Réference : '.$annonce["id"].'</li>
                            <a class="nav-link" href="index.php?action=demandeReservation&id='.$annonce["id"].'">Voir l\'offre</a>
                          </div>
                        </div>';
        }
        echo '</div></div></div>';
        $this->fin();
    }
    public function recherche($lesRecherche){
      //$this->entete();
      echo var_dump($lesRecherche);
      echo '
      <div class="container d-flex justify-content-center main-content">
      <div class="container-fluid bg-transparent my-4 p-3" style="position: relative;">
        <div class="row">
        <form method="POST" class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Entrer un mot clé" aria-label="Search" name="barRecherche">
                    <button class="btn btn-outline-success" type="submit" name="btnRecherche">Rechercher</button>
                  </form>
        ';
          foreach ($lesRecherche as $recherche) {
              echo '
              <div class="col-md-4 mb-4">
                <div class="card carte">
                  <div class="card-body">
                    <h5 class="card-text">' . $recherche["description"] . '</h5>
                    <h6 class="card-text">'.$recherche["codePostal"]." ".$recherche["ville"]. '</h6>
                    <img class="card-img" src="./images/'.$recherche["lienPhoto"].'">
                  </div>
                  <li class="list-group-item">Réference : ' . $recherche["id"] . '</li>
                  <a class="nav-link" href="index.php?action=demandeReservation&id='.$recherche ["id"].'">Voir l\'offre</a>
                </div>
              </div>
          ';
        }
        $this->fin();
    }
  // Deconnexion utilisateur
  public function deconnexion($message = null){
    $this->entete();
    session_destroy();
  }
  //Affichage connexion utilisateur
  public function connexion($message = null) {
    if(!isset($_SESSION)) {
      session_start();
    }
    $this->entete();
    if($message != null) {
      echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
    }
    echo "
      <div class='d-flex justify-content-center main-content'>
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

  //recherche
  public function recherchedeux() {
    $this->entete();
    echo '
    <form method="GET" class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Entrer un mot clé" aria-label="Search" name="barRecherche">
        <button class="btn btn-outline-success" type="submit" name="btnRecherche">Rechercher</button>
    </form>
    ';

    $this->fin();
  }


  //Affichage inscription utilisateur
  public function inscription($message = null) {
    $this->entete();
    if($message != null) {
      echo "<div class='alert alert-danger' role='alert'>".$message."</div>";
    }
    echo "
      <div class='d-flex justify-content-center main-content'>
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
  public function demandeReservation($annonce, $date1, $date2) {
    $this->entete();

    echo '
          <div class="container d-flex justify-content-center main-content">
              <div class="container-fluid bg-transparent my-4 p-1" style="position: relative;">
                  <div class="row">
                      <div class="col-md-12 mb-4">
                          <div class="card carte">
                              <div class="card-body text-center">
                                  <h1> '.$annonce["description"].' </h1>
                                  <h3>'.$annonce["codePostal"].' - <b><i>'.$annonce["ville"].'</b></i></h3>
                                  
                                  <img class="card-img" src="./images/'.$annonce["lesPhotos"][0]["lien"].'">
                                  <h6> Disponible du '.$date1.' au '.$date2.'</h6>
                                  <form method="post" action="">
                                      <p> Date de début de réservation : <input type="date" name="dateDebut" value="" min="'.$annonce["lesDisponibilites"]["dateDebut"].'" max="'.$annonce["lesDisponibilites"]["dateFin"].'" required></p>
                                      <p> Date de fin de réservation : <input type="date" name="dateFin" value="" min="'.$annonce["lesDisponibilites"]["dateDebut"].'" max="'.$annonce["lesDisponibilites"]["dateFin"].'" required></p>
                                      <input type="submit" name="valider" value="ok">
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>';

    $this->fin();
  }
  public function mesannonces($lesAnnonces) {
    $this->entete();
    echo '
    <div class="container d-flex justify-content-center main-content">
        <div class="container-fluid bg-transparent my-4 p-3">
            <div class="row">';
    foreach($lesAnnonces as $annonce) {
      echo '
                  <div class="col-md-12 mb-4">
                    <div class="card flex-row">
                      <img class="card-img-left custom-image" src="./images/'.$annonce["lienPhoto"].'" style="max-width: 30%;"/>
                      <div class="card-body d-flex flex-column">
                        <div id="ici">
                          <h4 class="card-title h5 h4-sm">'.$annonce["description"].'</h4>
                          <p class="card-text">'.$annonce["codePostal"]." ".$annonce["ville"].'</p>
                        </div>
                        <div class="mt-auto">
                          <i>Référence :'.$annonce["id"].'</i>
                          <a class="float-end" href="index.php?action=demandeReservation&id='.$annonce["id"].'">
                              <i class="fa-solid fa-arrow-right text-noir"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>';
    }
    echo '
            </div>
        </div>
    </div>';
    $this->fin();
  }

  public function reservation($lesReservations) {
    $this->entete();

    echo '
  <div class="container d-flex justify-content-center main-content">
  <div class="container-fluid bg-transparent my-4 p-3">
      <div class="row">';
    foreach($lesReservations as $reservation) {
      echo '
            <div class="col-md-12 mb-4">
              <div class="card flex-row">
                <div class="card-body d-flex flex-column">
                  '.$reservation["dateDebut"].'
                </div>
              </div>
            </div>';
    }
    echo '
        </div>
  </div>
  </div>';

    $this->fin();
  }






  public function erreur404() {
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

  public function erreur($message = null) {
    $this->entete();

    echo '
    <div class="container d-flex justify-content-center main-content">
    <div class="container-fluid bg-transparent my-4 p-3">
        <div class="row">';
        if($message != null){
          echo '<h1>Erreur  : '.$message.'</h1>';
        }
      echo '
      <br/></div>
      </div>
      </div>
    ';

    $this->fin();
  }
  public function fin() {
    echo "
      </body>
      <script src='https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js'></script>
      <script src='https://kit.fontawesome.com/18d92584e8.js' crossorigin='anonymous'></script>
      </html>";
  }
}
?>