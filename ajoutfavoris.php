<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Connexion à la base de données */
include("connexionBDD.php");

    
$idProduit = $_GET['idproduit'];

if(isset($_SESSION['login'])){
	//Utilisateur connecté, on regarde si il a un panier actif
	//On envoie direct l'insert. Si le produit est déjà dans les favoris il n'y sera pas ajouté
	$req = $bdd -> prepare("
		INSERT INTO favoris 
		VALUES(:user, :prod)"
	);
	try {
		$req-> execute(array(
		'user' => $_SESSION['login'],
		'prod' => $idProduit
		));
	} catch (Exception $e) {
		//C'est deja dedans, rien à faire
	}
}
    
    
$redir = "produit.php?idproduit=" . $idProduit;
header('Location: ' . $redir);
?>
