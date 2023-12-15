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

        echo var_dump($_GET);

        if(isset($_GET["btnRecherche"]) && !empty($_GET["barRecherche"])){
            $recherche = htmlspecialchars($_GET["barRecherche"]);
            $champ = $_GET["barRecherche"];
            $champ = trim($champ);
            $champ = strip_tags($champ);

            $requete = $this->pdo->prepare("SELECT logement.*, photo.lien AS lienPhoto  FROM logement 
            inner join disponibilite on logement.id = disponibilite.idLogement 
            inner join equipement on logement.id = equipement.idLogement 
            inner join photo on logement.id = photo.idLogement 
            inner join piece on logement.id = piece.idLogement 
            inner join reservation on logement.id = reservation.idLogement 
            WHERE description LIKE :champ OR ville LIKE :champ_ville or libelle like :champ_libelle or type like :champ_type");
            $requete->bindParam(":champ", $champ, \PDO::PARAM_STR);
            $requete->bindParam(":champ_ville", $champ, \PDO::PARAM_STR);
            $requete->bindParam(":champ_libelle", $champ, \PDO::PARAM_STR);
            $requete->bindParam(":champ_type", $champ, \PDO::PARAM_STR);
            $requete -> execute(array(':champ' => "%".$champ."%",':champ_ville' => "%".$champ."%",':champ_libelle' => "%".$champ."%",':champ_type' => "%".$champ."%"));
            return $requete->fetchAll();
        }

    }
}
?>