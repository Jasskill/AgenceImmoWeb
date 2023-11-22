<?php
class controleur{
    public function accueil() {
		(new vue)->accueil();
	}
	public function erreur404(){
		(new vue)->erreur404();
	}
	//Controleur Connexion
	public function connexion(){
		if(isset($_POST['buttonconnect'])){
			$mail = htmlspecialchars($_POST['mail']);
			$mdp = htmlspecialchars($_POST['mdp']);
			if((new utilisateur)->connexion($mail,$mdp)){
				(new vue)->accueil();
				$message='Connexion réussie!';
			}else{
				(new vue)->connexion("Identifiant ou mot de passe incorrect.");
			}
		}else{
			(new vue)->connexion();
		}
	}
	//Controleur Inscription
	public function inscription(){
		if(isset($_POST["buttonregister"])){
			$mdp = htmlspecialchars($_POST['mdp']);
			$mdp2 = htmlspecialchars($_POST['mdp2']);
			if($mdp == $mdp2){
				$nom = htmlspecialchars($_POST['nom']);
				$prenom = htmlspecialchars($_POST['prenom']);
				$mail = htmlspecialchars($_POST['mail']);
				$mdp = password_hash($mdp, PASSWORD_BCRYPT);
				if(!(new utilisateur)->dejaInscrit($mail)) {
					(new utilisateur)->inscription($mdp, $nom, $prenom, $mail, $proprietaire);
					(new vue)->connexion();
					$message =' Inscription réussie ! ';
					echo "<script type='text/javascript'>windows.alert('".$message."');</script>"; 
				}else{
					(new vue)->inscription("Le mail est déjà associé à un autre compte ! ");
				}
			}else {
				(new vue)->inscription("Les deux mots de passe ne sont pas identiques ! ");
			}
		}else{
			(new vue)->inscription();
		}
	}
}
?>