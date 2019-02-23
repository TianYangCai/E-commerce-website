<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Connexion à la base de données */
include("connexionBDD.php");

/*Check si ce login ou mail existe déjà*/
$req = $bdd->prepare("
	SELECT * 
	FROM Utilisateurs 
	WHERE login =:p1 
		OR email =:p2");
$req->bindParam('p1', $_POST['login'], PDO::PARAM_STR);
$req->bindParam('p2', $_POST['mail'], PDO::PARAM_STR);
$req->execute();
                     
                     
                     
                     
                     
$res = $req->fetch(PDO::FETCH_ASSOC); /*Login clé donc un seul tuple à récupérer */

if(!$res){
                     
	/*$pw = password_hash($_POST['mdp'], PASSWORD_DEFAULT);*/
	$pw = $_POST['mdp'];

	/*Insertion du nouvel utilisateur*/
	$req = $bdd -> prepare("INSERT INTO Utilisateurs VALUES(:log, :nom, :prenom, :mdp, :mail, :adresse, :cp, :ville, :sexe, :age)");
	$req->execute(array(
		'log' => $_POST['login'],
		'nom' => $_POST['nom'],
		'prenom' => $_POST['prenom'],
		'mdp' => $pw,
		'mail' => $_POST['mail'],
		'adresse' => $_POST['adresse'],
		'cp' => $_POST['codePostal'],
		'ville' => $_POST['ville'],
		'sexe' => $_POST['sexe'],
		'age' => $_POST['age']));
	session_start();
	$_SESSION['login'] = $_POST['login'];
	$redir = "index.php";
} else {
	$redir = "inscription.php?success=0";
}
header('Location: ' . $redir);
?>
