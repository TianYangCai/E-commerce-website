<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    /* Connexion à la base de données */
    include("connexionBDD.php");
    
    
    $idProduit = $_GET['idproduit'];

    $reqSupprimerFavoris = $bdd->prepare("
         DELETE
         FROM favoris
         WHERE produit = :idproduit
         AND utilisateur = :user"
         );
    $reqSupprimerFavoris->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $reqSupprimerFavoris->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
    $reqSupprimerFavoris->execute();

    $redir = "favoris.php";
    header('Location: ' . $redir);
?>
