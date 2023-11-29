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
        $requete = "SELECT Logement.id AS id, rue, codePostal, ville, description, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal 
        FROM Logement 
        INNER JOIN Piece ON Logement.id = Piece.idLogement 
        WHERE  
        Logement.id = :unId
        GROUP BY Logement.id"

    if(isset($_GET["btnRecherche"]) && !empty($_GET["barRecherche"])){
        $recherche = htmlspecialchars($_GET["barRecherche"]);
        $champ = $_GET["barRecherche"];
        $champ = trim($champ);
        $champ = strip_tags($champ;)
    }

    }

?>




SELECT Logement.id AS id, rue, codePostal, ville, description, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal 
                FROM Logement 
                INNER JOIN Piece ON Logement.id = Piece.idLogement 
                WHERE Logement.id IN (SELECT idLogement FROM disponibilite)