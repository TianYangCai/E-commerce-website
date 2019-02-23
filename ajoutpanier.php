<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Connexion à la base de données */
include("connexionBDD.php");


$idProduit = $_POST['idproduit'];
$quantite = $_POST['quantite'];


if(isset($_SESSION['login'])){
	//Utilisateur connecté, on regarde si il a un panier actif
	/*Récupération du panier de l'utilisateur*/
	$reqPanierExiste = $bdd->prepare("
		SELECT idpanier, utilisateur
		FROM paniersNonSoldes 
		WHERE utilisateur = :p1"
	);
    
    
	$reqPanierExiste->bindParam('p1', $_SESSION['login'], PDO::PARAM_STR);
	$reqPanierExiste->execute();
	$resPanierExiste = $reqPanierExiste->fetch(PDO::FETCH_ASSOC);

	if(!$resPanierExiste){//L'utilisateur n'a pas de panier actif, on lui en créé un. On cherche donc d'abord l'id à donner au panier
		$reqIdPanier = $bdd->prepare("
			SELECT MAX(idpanier) as newid
			FROM Paniers"
		);
		$reqIdPanier->execute();
		$resIdPanier = $reqIdPanier->fetch(PDO::FETCH_ASSOC);
		$idPanier = $resIdPanier['newid'] + 1;

		$reqNouveauPanier = $bdd -> prepare("
			INSERT INTO paniers
			VALUES(:id, NOW(), :utilisateur)"
		);
		$reqNouveauPanier->execute(array(
			'id' => $idPanier,
			'utilisateur' => $_SESSION['login']
		));

	} else {
		$idPanier = $resPanierExiste['idpanier'];
	}
	//L'utilisateur a un panier actif. On y ajoute le nouveau produit. Si le produit était déjà dans le panier, on ajoute seulement 1 en quantité
	$reqProduitExiste = $bdd->prepare("
		SELECT quantite
		FROM ajoutPanier
		WHERE panier = :pan AND produit = :prod"
	);
	$reqProduitExiste->execute(array(
			'pan' => $idPanier,
			'prod' => $idProduit
	));
	$resProduitExiste = $reqProduitExiste->fetch(PDO::FETCH_ASSOC);

	if($resProduitExiste){
		$quantite = $quantite + $resProduitExiste['quantite'];
		$updateQuantite = $bdd -> prepare("
			UPDATE ajoutPanier
			SET quantite = :quant
			WHERE panier = :pan
				AND produit = :prod"
		);
		$updateQuantite->execute(array(
			'quant' => $quantite,
			'pan' => $idPanier,
			'prod' => $idProduit
		));
	} else {
		$reqAjoutPanier = $bdd -> prepare("
			INSERT INTO ajoutPanier
          VALUES(:pan, :prod, :quantite)"
		);
		$reqAjoutPanier->execute(array(
			'pan' => $idPanier,
			'prod' => $idProduit,
            'quantite' => $quantite
		));
	}
}
$redir = "produit.php?idproduit=" . $idProduit;
header('Location: ' . $redir);
?>
