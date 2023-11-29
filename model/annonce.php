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

    //Récupérer les logements dans la base de données
    public function recupererAnnonces($nb1 = null, $nb2 = null){
        $sql = "SELECT Logement.id AS id, rue, codePostal, ville, description, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal, Photo.lien AS lienPhoto
                FROM Logement 
                INNER JOIN Piece ON Logement.id = Piece.idLogement 
                INNER JOIN Photo ON Logement.id = Photo.idLogement 
                WHERE Logement.id IN (SELECT idLogement FROM disponibilite)
                GROUP BY Logement.id ";
        if($nb1 != null && $nb2 != null){
            $sql .= "LIMIT :n1 , :n2 ;";
        }
                
        $req = $this->pdo->prepare($sql);
        if($nb1 != null && $nb2 != null){
            $req->bindParam(":n1", $nb1, \PDO::PARAM_INT);
            $req->bindParam(":n2", $nb2, \PDO::PARAM_INT);
        }
        $res = $req->execute();
        $lesAnnonces = $req->fetchAll();

        return $lesAnnonces;
    }

    public function recupererUneAnnonce($id){
        $sql = "SELECT Logement.id AS id, rue, codePostal, ville, description, idUtilisateur, COUNT(Piece.id) AS nbPieces, SUM(surface) AS surfaceTotal 
                FROM Logement 
                INNER JOIN Piece ON Logement.id = Piece.idLogement 
                WHERE Logement.id = :unId
                GROUP BY Logement.id";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(":unId", $id, \PDO::PARAM_INT);
        $res = $req->execute();
        $annonce = $req->fetch(\PDO::FETCH_ASSOC);

        $sqlPieces = "SELECT id, surface, type FROM piece WHERE idLogement = :unId";
        $reqPieces = $this->pdo->prepare($sqlPieces);
        $reqPieces->bindParam(":unId", $id, \PDO::PARAM_STR);
        $resPieces = $reqPieces->execute();
        $annonce["lesPieces"] = $reqPieces->fetchAll(\PDO::FETCH_ASSOC);

        $sqlEquipements = "SELECT id, libelle, idPiece FROM equipement WHERE idLogement = :unId";
        $reqEquipements = $this->pdo->prepare($sqlEquipements);
        $reqEquipements->bindParam(":unId", $id, \PDO::PARAM_STR);
        $resEquipements = $reqEquipements->execute();
        $annonce["lesEquipements"] = $reqEquipements->fetchAll(\PDO::FETCH_ASSOC);

        $sqlPhotos = "SELECT id, lien, idEquipement, idPiece FROM photo WHERE idLogement = :unId";
        $reqPhotos = $this->pdo->prepare($sqlPhotos);
        $reqPhotos->bindParam(":unId", $id, \PDO::PARAM_STR);
        $resPhotos = $reqPhotos->execute();
        $annonce["lesPhotos"] = $reqPhotos->fetchAll(\PDO::FETCH_ASSOC);

        

        return $annonce;
    }
}
?>