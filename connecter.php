
<?php

$login = $_POST['login'];
$pw = $_POST['password'];

/* Connexion à la base de données */
include("connexionBDD.php");

/*Recupération du mdp*/
$req = $bdd->prepare("SELECT mdp FROM Utilisateurs WHERE login = :p1");
$req->bindParam('p1', $login, PDO::PARAM_STR);
$req->execute();

/*Verification que le mot de passe est le bon*/
$res = $req->fetch(PDO::FETCH_ASSOC); /*Login clé donc un seul tuple à récupérer */

if(!$res){
	$redir = "connexion.php?success=0";
} else {
	if($pw == $res['mdp']) {
		session_start();
		$_SESSION['login'] = $login;
		$redir = "index.php";
	} else {
		$redir = "connexion.php?success=0";
	}
}

header('Location: ' . $redir);
?>
