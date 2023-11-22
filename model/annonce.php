<?php
Class annonce{
    private $pdo;

    public function __construct(){
        $config=parse_ini_file("config.ini");
        
        try{
            $this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}

    //Réccupérer les logements dans la base de données
    public function recupererAnnonce(){
        $sql = "SELECT Logement.id, rue, codePostal, ville, idUtilisateur, COUNT(Piece.id), SUM(surface) FROM Logement INNER JOIN Piece ON Logement.id = Piece.idLogement GROUP BY Logement.id";
        $req = $this->pdo->prepare($sql);
    }

    //récupperer pieces


    //reccuperer equipement


    //réccuperer photos 
}
?>