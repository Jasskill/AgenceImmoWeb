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
    public function recupererAnnonce($nb1, $nb2){
        $sql = "SELECT Logement.id AS id, rue, codePostal, ville, description, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal 
                FROM Logement 
                INNER JOIN Piece ON Logement.id = Piece.idLogement 
                WHERE Logement.id IN (SELECT idLogement FROM disponibilite)
                GROUP BY Logement.id
                LIMIT :n1 , :n2 ";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(":n1", $nb1, \PDO::PARAM_INT);
        $req->bindParam(":n2", $nb2, \PDO::PARAM_INT);
        $res = $req->execute();
        $lesAnnonces = $req->fetchAll();

        foreach($lesAnnonces as $annonce){
            $sqlPieces = "SELECT id, surface, type FROM piece WHERE idLogement = :leLogement";
            $reqPieces = $this->pdo->prepare($sqlPieces);
            $reqPieces->bindParam(":leLogement", $annonce["id"], \PDO::PARAM_STR);
            $resPieces = $reqPieces->execute();
            $annonce["lesPieces"] = $reqPieces->fetchAll();

            $sqlEquipements = "SELECT id, libelle, idPiece FROM equipement WHERE idLogement = :leLogement";
            $reqEquipements = $this->pdo->prepare($sqlEquipements);
            $reqEquipements->bindParam(":leLogement", $annonce["id"], \PDO::PARAM_STR);
            $resEquipements = $reqEquipements->execute();
            $annonce["lesEquipements"] = $reqEquipements->fetchAll();

            $sqlPhotos = "SELECT id, lien, idEquipement, idPiece FROM photo WHERE idLogement = :leLogement";
            $reqPhotos = $this->pdo->prepare($sqlPhotos);
            $reqPhotos->bindParam(":leLogement", $annonce["id"], \PDO::PARAM_STR);
            $resPhotos = $reqPhotos->execute();
            $annonce["lesPhotos"] = $reqPhotos->fetchAll();
        }

        return $lesAnnonces;
    }
}
?>