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
        $stmt = $this->pdo->prepare("SELECT rue, codePostal, ville, id, idProproetaire, COUNT(Piece.id), surface, libelle, lien FROM ")
    }

    //récupperer pieces


    //reccuperer equipement


    //réccuperer photos 
}
?>