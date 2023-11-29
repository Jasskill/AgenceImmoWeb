<?php

class Controleur {
    private $vue;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->vue = new Vue();
    }

    public function accueil() {
        $lesAnnonces = (new Annonce)->recupererAnnonces(0, 5);
        (new vue)->accueil($lesAnnonces);
    }
    public function rechercher(){
        $lesAnnonces = (new Annonce)->recupererAnnonces(0,5);
        $this->vue->recherche($recherche);
    }

    public function erreur404() {
        (new vue)->erreur404();
    }

    // Contrôleur Connexion
    public function connexion() {
        if (isset($_POST['buttonconnect'])) {
            $mail = htmlspecialchars($_POST['mail']);
            $mdp = htmlspecialchars($_POST['mdp']);
            
            $utilisateur = new Utilisateur();
            
            if ($utilisateur->connexion($mail, $mdp)) {
				$_SESSION['estconnecte'] = true;
                (new vue)->accueil();
                $message = 'Connexion réussie!';
            } else {
                (new vue)->connexion("Identifiant ou mot de passe incorrect.");
            }
        } else {
            (new vue)->connexion();
        }
    }

    // Contrôleur Inscription
    public function inscription() {
        if (isset($_POST["buttonregister"])) {
            $mdp = htmlspecialchars($_POST['mdp']);
            $mdp2 = htmlspecialchars($_POST['mdp2']);
            
            if ($mdp == $mdp2) {
                $nom = htmlspecialchars($_POST['nom']);
                $prenom = htmlspecialchars($_POST['prenom']);
                $mail = htmlspecialchars($_POST['mail']);
                $mdpHash = password_hash($mdp, PASSWORD_BCRYPT);
                
                $utilisateur = new Utilisateur();
                
                if (!$utilisateur->dejaInscrit($mail)) {
                    $utilisateur->inscription($mdpHash, $nom, $prenom, $mail);
                    (new vue)->connexion();
                    $message = 'Inscription réussie !';
                    echo "<script type='text/javascript'>window.alert('" . $message . "');</script>";
                } else {
                    (new vue)->inscription("Le mail est déjà associé à un autre compte !");
                }
            } else {
                (new vue)->inscription("Les deux mots de passe ne sont pas identiques !");
            }
        } else {
            (new vue)->inscription();
        }
    }
    public function logout(){
        session_destroy();
    }

    public function demandeReservation(){
        if(isset($_GET["id"])){
            $annonce = (new annonce)->recupererUneAnnonce($_GET["id"]);
            (new vue)->demandeReservation($annonce);
        }else{
            $this->erreur404();
        }
    }
}

?>
