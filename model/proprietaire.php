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
        $sql ='SELECT * FROM logement WHERE idProprietaire = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id',$idProprietaire, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
}

?>
