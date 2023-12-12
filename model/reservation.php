<?php
class reservation
{
    private $pdo;

    public function __construct()
    {
        $config = parse_ini_file("config.ini");

        try {
            $this->pdo = new \PDO("mysql:host=" . $config["host"] . ";dbname=" . $config["database"] . ";charset=utf8", $config["user"], $config["password"]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function recupererReservations($idClient){
        $sql = "SELECT id, dateDebut, dateFin, idDisponibilite FROM reservation WHERE idClient = :unId;";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(":unId", $idClient, \PDO::PARAM_INT);
        $res = $req->execute();
        if($res){
            $lesReservations = $req->fetchAll(\PDO::FETCH_ASSOC);
            $lesReservations["code"] = true;
            return $lesReservations;
        }else{
            $erreur["code"] = false;
            $erreur["msg"] = "Echec de la requete";
            return $erreur;
        }
    }
    //Calculer tarif
    public function calculTarif($idReservation){
        $sql = "SELECT DATEDIFF(reservation.dateFin, reservation.dateDebut as nbjours, disponibilite.tarif
                FROM reservation
                INNER JOIN disponibilite ON reservation.idDisponibilite = disponibilite.id
                WHERE reservation.id = :idReservation
        ";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':idReservation', $idReservation, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch();
        $duree = $resultat['duree'];
        $tarifjour = $resultat['tarif'];
        $total = $duree * $tarifjour;
        return $total;
    }
}