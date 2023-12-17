<?php

class Controleur
{
    private $vue;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->vue = new Vue();
    }

    public function accueil($message = null)
    {
        $lesAnnonces = (new annonce)->recupererAnnonces(0, 5);
        (new vue)->accueil($lesAnnonces, $message);
    }
    public function recherche()
    {
        $lesRecherche = (new rechercher)->recupAnnonceRecherche();
        (new vue)->recherche($lesRecherche);
    }

    public function erreur404()
    {
        (new vue)->erreur404();
    }

    public function erreur()
    {
        (new vue)->erreur();
    }

    // Contrôleur Annonce
    public function boutonannonce()
    {
        $lesAnnonces = (new Annonce)->recupererAnnonces();
        (new vue)->mesannonces($lesAnnonces);

    }
    // Contrôleur Connexion
    public function connexion($message = null)
    {
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
    public function inscription()
    {
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
                    $res = $utilisateur->inscription($mdpHash, $nom, $prenom, $mail);
                    if ($res) {
                        (new vue)->connexion();
                        $message = 'Inscription réussie !';
                        echo "<script type='text/javascript'>window.alert('" . $message . "');</script>";
                    } else {
                        (new vue)->erreur("L'inscription a échoué, veuillez réessayer plus tard");
                    }

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
    public function logout()
    {
        session_destroy();
    }

    public function demandeReservation()
    {

        if (isset($_GET["id"])) {
            if (isset($_POST["valider"])) {
                if (isset($_SESSION["Client_session"])) {
                    $annonce = (new annonce)->recupererUneAnnonce($_GET["id"]);
                    $dateDebut = htmlspecialchars($_POST["dateDebut"]);
                    $dateFin = htmlspecialchars($_POST["dateFin"]);
                    $idD = htmlspecialchars($_GET["id"]);
                    (new annonce)->creerReservation($dateDebut, $dateFin, $idD, $_SESSION["Client_session"]);
                    if ($annonce["lesDisponibilites"]["dateDebut"] != $dateDebut) {
                        (new annonce)->creerDisponibilite($annonce["lesDisponibilites"]["dateDebut"], $dateDebut, $annonce["id"], $annonce["lesDisponibilites"]["tarif"], $idD);
                    }
                    if ($dateFin != $annonce["lesDisponibilites"]["dateFin"]) {
                        (new annonce)->creerDisponibilite($dateFin, $annonce["lesDisponibilites"]["dateFin"], $annonce["id"], $annonce["lesDisponibilites"]["tarif"], $idD);
                    }
                    header("Location: index.php?action=succesReservation");
                    exit;
                } else {
                    $this->connexion("Veuiller vous connecter");
                }
            } else {
                $annonce = (new annonce)->recupererUneAnnonce($_GET["id"]);
                $dateDebut = $this->recupereDate($annonce["lesDisponibilites"]["dateDebut"]);
                $dateFin = $this->recupereDate($annonce["lesDisponibilites"]["dateFin"]);
                (new vue)->demandeReservation($annonce, $dateDebut, $dateFin);
            }
        } else {
            $this->erreur404();
        }
    }

    public function reservation()
    {
        if (isset($_SESSION["Client_session"])) {
            $lesReservations = (new reservation)->recupererReservations($_SESSION["Client_session"]);
            if ($lesReservations != false) {
                (new vue)->reservation($lesReservations);
            } else {
                (new vue)->erreur("Impossible de récupérer les réservations");
            }
        } else {
            $this->erreur404();
        }
    }

    public function annulerReservation(){
        if(isset($_GET["id"])){
            (new reservation)->annulerReservation($_GET["id"]);
        }else{
            (new vue)->erreur404();
        }
    }

    public function succesReservation(){
        (new vue)->succesReservation();
    }

    public function recupereDate($date)
    {
        $dateTab = explode("-", $date);
        $stringDate = "";
        if ($dateTab[2] == "1") {
            $stringDate = "1er ";
        } else {
            $stringDate = $dateTab[2] . " ";
        }
        switch ($dateTab[1]) {
            case "01":
                $stringDate .= "janvier ";
                break;
            case "02":
                $stringDate .= "février ";
                break;
            case "03":
                $stringDate .= "mars ";
                break;
            case "04":
                $stringDate .= "avril ";
                break;
            case "05":
                $stringDate .= "mai ";
                break;
            case "06":
                $stringDate .= "juin ";
                break;
            case "07":
                $stringDate .= "juillet ";
                break;
            case "08":
                $stringDate .= "août ";
                break;
            case "09":
                $stringDate .= "septembre ";
                break;
            case "10":
                $stringDate .= "octobre ";
                break;
            case "11":
                $stringDate .= "novembre ";
                break;
            case "12":
                $stringDate .= "décembre ";
                break;
            default:
                $stringDate .= $dateTab[1];
                break;
        }
        $stringDate .= $dateTab[0];

        return $stringDate;
    }

    public function mesLogements()
    {
        if (isset($_SESSION['Proprietaire_session'])) {
            $idProprietaire = $_SESSION['Proprietaire_session'];
            $lesLogements = (new Proprietaire)->lesLogements($idProprietaire);
            (new Vue)->mesLogements($lesLogements);
        } else {
            (new Vue)->erreur404();
        }
    }
    // Reservations cote clients
    public function mesReservationsClient()
    {
        if (isset($_SESSION['Client_session'])){
            $idClient = $_SESSION['Client_session'];
            $lesReservations = (new reservation)->recupererReservations($idClient);
            (new Vue)->mesReservationsClient($lesReservations);
        }else{
            (new Vue)->erreur404();
        }
    }
    //Reservation avec un LOGEMENTID passer en paramètre (coté proprioétaire)
    public function GestionsReservationIdLogement(){
        if(isset($_SESSION['Proprietaire_session']) && isset($_GET['idLogement'])){
            $idProprietaire = (int)$_SESSION['Proprietaire_session'];
            $idLogement = $_GET['idLogement'];
            $lesReservations = (new proprietaire)->mesLogementsLoue($idProprietaire, $idLogement);
            (new Vue)->GestionsReservationIdLogement($lesReservations);
        }else{
            (new Vue)->erreur404();
        }
    }
    //Affichage et ajout d'une disponibilite avec un LOGEMENT ID coté proprio
    public function GestionsDisponibiliteIdLogement(){
        if (isset($_SESSION['Proprietaire_session'])){
            $idLogement = $_GET['idLogement'];;
            $lesDisponibilites = (new Proprietaire)->AffichageAjoutDisponibilite($idLogement);
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $dateDebut = $_POST['dateDebut'];
                $dateFin = $_POST['dateFin'];
                $tarif = $_POST['tarif'];
                (new Proprietaire)->ajouterDisponibiliteLogement($idLogement, $dateDebut, $dateFin, $tarif);
                $lesDisponibilites = (new Proprietaire)->AffichageAjoutDisponibilite($idLogement);
            }
            (new Vue)->GestionsDisponibiliteIdLogement($lesDisponibilites);
        }else{
            (new Vue)->erreur404();
        }
    }
}

?>