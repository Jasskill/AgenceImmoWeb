<?php

class Proprietaire {
    private $pdo;

    public function __construct(){
        $config=parse_ini_file("config.ini");
        
        try{
            $this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    //Récuperer tout les logements d'un propriétaire passer en paramètre
    public function lesLogements($idProprietaire){
        $sql ='SELECT logement.*, photo.lien 
               FROM logement
               INNER JOIN photo ON logement.id = photo.idLogement
               WHERE logement.idProprietaire = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id',$idProprietaire, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
    //Récuperer toute les réservations qu'a le logement d'un proprietaire
    public function mesLogementsLoue($idProprietaire, $idLogement){
        $sql = 'SELECT reservation.*, 
        utilisateur.nom AS clientNom,
        utilisateur.prenom AS clientPrenom,
        logement.description AS logementDescription,
        photo.lien AS lienPhoto
        FROM reservation
        INNER JOIN disponibilite ON reservation.idDisponibilite = disponibilite.id
        INNER JOIN logement ON disponibilite.idLogement = logement.id
        INNER JOIN utilisateur ON reservation.idClient = utilisateur.id
        INNER JOIN photo ON logement.id = photo.id
        WHERE logement.idProprietaire = :idProprietaire AND logement.id = :idLogement';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':idProprietaire',$idProprietaire, PDO::PARAM_INT);
        $req->bindParam(":idLogement", $idLogement, \PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
