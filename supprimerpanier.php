<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    /* Connexion à la base de données */
    include("connexionBDD.php");
    
    
    $idProduit = $_GET['idproduit'];
    $idPanier = $_GET['idpanier'];
    
    $reqSupprimerPanier = $bdd->prepare("
         DELETE
         FROM ajoutpanier
         WHERE produit = :idproduit
         AND panier = :idpanier"
         );
    $reqSupprimerPanier->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $reqSupprimerPanier->bindParam('idpanier', $idPanier, PDO::PARAM_STR);
    $reqSupprimerPanier->execute();
    
    $redir = "panier.php";
    header('Location: ' . $redir);
    ?>
