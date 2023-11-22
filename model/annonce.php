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
        $sql = "SELECT Logement.id AS id, rue, codePostal, ville, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal 
                FROM Logement 
                INNER JOIN Piece ON Logement.id = Piece.idLogement 
                WHERE Logement.id IN (SELECT idLogement FROM disponibilite)
                GROUP BY Logement.id";
        $req = $this->pdo->prepare($sql);
        $res = $req->execute();
        $lesAnnonces = $req->fetchAll();

        foreach($lesAnnonces as $annonce){
            $annonce["id"] 
            $sql = "SELECT id, libelle, idPiece FROM equipement WHERE idLogement = :leLogement" ;
            $req = $this->pdo->prepare($sql);
            $req->bindParam(":leLogement", $annonce["id"], \PDO::PARAM_STR);
            $res = $req->execute();
            $annonce["lesEquipements"] = $req->fetchAll();
        }
    }

    //récupperer pieces


    //reccuperer equipement


    //réccuperer photos 
}
?>