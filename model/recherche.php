<?php
Class rechercher{
    private $pdo;

    public function __construct(){
        $config=parse_ini_file("config.ini");
        try{
            $this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}

    //Reccuperer les logements par rapport aux recherches
    public function recupAnnonceRecherche(){

        if(isset($_GET["btnRecherche"]) && !empty($_GET["barRecherche"])){
            $recherche = htmlspecialchars($_GET["barRecherche"]);
            $champ = $_GET["barRecherche"];
            $champ = trim($champ);
            $champ = strip_tags($champ;)

            $requete = "SELECT * FROM logement 
            inner join disponibilite on logement.id = disponibilite.idLogement 
            inner join equipement on logement.id = equipement.idLogement 
            inner join photo on logement.id = photo.idLogementn 
            inner join piece on logement.id = piece.idLogement 
            inner join reservation on logement.id = reservation.idLogement 
            WHERE description LIKE ? OR ville LIKE ? or libelle like ? or type like ?";
            $requete->execute(array("%".$champ."%", "%".$champ."%", "%".$champ."%", "%".$champ."%"));
            $lesRecherche = $requete->fetchAll();
        }

    }

?>