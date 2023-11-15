<?php
session_start();

// Test de connexion à la base
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
} catch(Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
}

// Chargement des fichiers MVC
require("control/controleur.php");
require("view/vue.php");
require("model/Utilisateur.php");

//Routes
if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "accueil":
            (new controleur)->accueil();
            break;
        case "connexion":
            (new controleur)->connexion();
            break;
        case "inscription":
            (new controleur)->inscription();
            break;
        case "acceesPropritaire":
            (new controleur)->acceesPropritaire();
            break;
        case "recherche":
            (new controleur)->recherche();
            break;
        case "ajoutDisponibilite":
            (new controleur)->ajoutDisponibilite();
            break;
        case "demandeReservation":
            (new controleur)->demandeReservation();
            break;
        default:
            //route par default : erreur404
            (new controleur)->erreur404():
            break;
    }
}else{
    // Pas d'action précisée = afficher l'accueil
    (new controleur)->accueil();
}
?>