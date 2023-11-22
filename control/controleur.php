<?php

class Controleur {
    private $vue;

    public function __construct() {
        $this->vue = new Vue();
    }

    public function accueil() {
        $this->vue->accueil();
    }

    public function erreur404() {
        $this->vue->erreur404();
    }

    // Contrôleur Connexion
    public function connexion() {
        if (isset($_POST['buttonconnect'])) {
            $mail = htmlspecialchars($_POST['mail']);
            $mdp = htmlspecialchars($_POST['mdp']);
            
            $utilisateur = new Utilisateur();
            
            if ($utilisateur->connexion($mail, $mdp)) {
				$_SESSION['estconnecte'] = true;
                $this->vue->accueil();
                $message = 'Connexion réussie!';
            } else {
                $this->vue->connexion("Identifiant ou mot de passe incorrect.");
            }
        } else {
            $this->vue->connexion();
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
                    $this->vue->connexion();
                    $message = 'Inscription réussie !';
                    echo "<script type='text/javascript'>window.alert('" . $message . "');</script>";
                } else {
                    $this->vue->inscription("Le mail est déjà associé à un autre compte !");
                }
            } else {
                $this->vue->inscription("Les deux mots de passe ne sont pas identiques !");
            }
        } else {
            $this->vue->inscription();
        }
    }
}

?>
