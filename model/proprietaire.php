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
    public function lesLogements($proprietaire){
        $sql ='SELECT * FROM logement WHERE idProprietaire = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id',$proprietaire, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    //Récuperer les réservations d'un logement passée en paramètre
    public function lesDisponibilites($idlogement){
        $sql ='SELECT dateDebut, dateFin FROM disponibilite WHERE idLogement = :id AND valide = 1';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id',$idlogement, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();

    }


}

?>
