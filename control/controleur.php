<?php

class Controleur {
    private $vue;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->vue = new Vue();
    }

    public function accueil($message = null) {
        $lesAnnonces = (new annonce)->recupererAnnonces(0, 5);
        (new vue)->accueil($lesAnnonces, $message);
    }
    public function rechercher(){
        $lesAnnonces = (new annonce)->recupererAnnonces(0,5);
        (new vue)->recherche($recherche);
    }

    public function erreur404() {
        (new vue)->erreur404();
    }
    // Contrôleur Annonce
    public function boutonannonce(){
        $lesAnnonces = (new Annonce)->recupererAnnonces();
        (new vue)->mesannonces($lesAnnonces);
        
      }
    // Contrôleur Connexion
    public function connexion($message = null) {
        if (isset($_POST['buttonconnect'])) {
            $mail = htmlspecialchars($_POST['mail']);
            $mdp = htmlspecialchars($_POST['mdp']);
            
            $utilisateur = new Utilisateur();
            
            if ($utilisateur->connexion($mail, $mdp)) {
				$_SESSION['estconnecte'] = true;
                $this->accueil();
                $message = 'Connexion réussie!';
            } else {
                (new vue)->connexion("Identifiant ou mot de passe incorrect.");
            }
        } else {
            (new vue)->connexion($message);
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
            if(isset($_POST["valider"])){
                if(isset($_SESSION["connect"])){
                    $annonce = (new annonce)->recupererUneAnnonce($_GET["id"]);
                    $dateDebut = htmlspecialchars($_POST["dateDebut"]);
                    $dateFin = htmlspecialchars($_POST["dateFin"]);
                    $idD = htmlspecialchars($_GET["id"]);
                    (new annonce)->creerReservation($dateDebut, $dateFin, $idD, $_SESSION["connect"]);
                    if($annonce["lesDisponibilites"]["dateDebut"] != $dateDebut){
                        (new annonce)->creerDisponibilite($annonce["lesDisponibilites"]["dateDebut"], $dateDebut, $annonce["id"], $annonce["lesDisponibilites"]["tarif"], $idD);
                    }
                    if($dateFin != $annonce["lesDisponibilites"]["dateFin"]){
                        (new annonce)->creerDisponibilite($dateFin, $annonce["lesDisponibilites"]["dateFin"], $annonce["id"], $annonce["lesDisponibilites"]["tarif"], $idD);
                    }
                    header("Location: index.php")
                }else{
                    $this->connexion("Veuiller vous connecter");
                }
            }else{
                $annonce = (new annonce)->recupererUneAnnonce($_GET["id"]);
                $dateDebut = $this->recupereDate($annonce["lesDisponibilites"]["dateDebut"]);
                $dateFin = $this->recupereDate($annonce["lesDisponibilites"]["dateFin"]);
                (new vue)->demandeReservation($annonce, $dateDebut, $dateFin);
            }
        }else{
            $this->erreur404();
        }
    }

    public function recupereDate($date){
        $dateTab = explode("-", $date);
        $stringDate = "";
        if($dateTab[2] == "1"){
            $stringDate = "1er ";
        }else{
            $stringDate = $dateTab[2]." ";
        }
        switch($dateTab[1]){
            case "01":
                $stringDate.= "janvier ";
                break;
            case "02":
                $stringDate.= "février ";
                break;
            case "03":
                $stringDate.= "mars ";
                break;
            case "04":
                $stringDate.= "avril ";
                break;
            case "05":
                $stringDate.= "mai ";
                break;
            case "06":
                $stringDate.= "juin ";
                break;
            case "07":
                $stringDate.= "juillet ";
                break;
            case "08":
                $stringDate.= "août ";
                break;
            case "09":
                $stringDate.= "septembre ";
                break;
            case "10":
                $stringDate.= "octobre ";
                break;
            case "11":
                $stringDate.= "novembre ";
                break;
            case "12":
                $stringDate.= "décembre ";
                break;
            default:
                $stringDate.= $dateTab[1];
                break;
        }
        $stringDate.= $dateTab[0];

        return $stringDate;
    }
}

?>
