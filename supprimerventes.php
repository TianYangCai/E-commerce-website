<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    /* Connexion à la base de données */
    include("connexionBDD.php");
    
    
    $idProduit = $_GET['idproduit'];
    
    //Supprimer les photos
    $findSupprimerPhoto = $bdd->prepare("
            SELECT *
            FROM photosproduit
            WHERE produit = :idproduit"
            );
    $findSupprimerPhoto->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $findSupprimerPhoto->execute();
    $resFindSupprimerPhoto = $findSupprimerPhoto->fetch(PDO::FETCH_ASSOC);
    
    if($resFindSupprimerPhoto){
        $reqSupprimerPhoto = $bdd->prepare("
            DELETE
            FROM photosproduit
            WHERE produit = :idproduit"
            );
        $reqSupprimerPhoto->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
        $reqSupprimerPhoto->execute();
    }

    //Supprimer les infos de livraison
    $findSupprimerLiv = $bdd->prepare("
            SELECT *
            FROM infoslivraison
            WHERE produit = :idproduit"
            );
    $findSupprimerLiv->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $findSupprimerLiv->execute();
    $resFindSupprimerLiv = $findSupprimerLiv->fetch(PDO::FETCH_ASSOC);
    
    if($resFindSupprimerLiv){
        $reqSupprimerLiv = $bdd->prepare("
            DELETE
            FROM infoslivraison
            WHERE produit = :idproduit"
            );
        $reqSupprimerLiv->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
        $reqSupprimerLiv->execute();
    }

    //Supprimer ajoutpanier
    $findSupprimerPanier = $bdd->prepare("
            SELECT *
            FROM ajoutpanier
            WHERE produit = :idproduit"
            );
    $findSupprimerPanier->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $findSupprimerPanier->execute();
    $resFindSupprimerPanier = $findSupprimerPanier->fetch(PDO::FETCH_ASSOC);
    
    if($resFindSupprimerPanier){
        $reqSupprimerPanier = $bdd->prepare("
           DELETE
           FROM ajoutpanier
           WHERE produit = :idproduit"
           );
        $reqSupprimerPanier->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
        $reqSupprimerPanier->execute();
    }
    
    //Supprimer favoris
    $findSupprimerFavoris = $bdd->prepare("
         SELECT *
         FROM favoris
         WHERE produit = :idproduit"
         );
    $findSupprimerFavoris->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $findSupprimerFavoris->execute();
    $resFindSupprimerFavoris = $findSupprimerFavoris->fetch(PDO::FETCH_ASSOC);
    
    if($resFindSupprimerFavoris){
        $reqSupprimerFavoris = $bdd->prepare("
            DELETE
            FROM favoris
            WHERE produit = :idproduit"
            );
        $reqSupprimerFavoris->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
        $reqSupprimerFavoris->execute();
    }
    
    
    //Supprimer produits
    $reqSupprimerProduit = $bdd->prepare("
         DELETE
         FROM produits
         WHERE idproduit = :idproduit"
         );
    $reqSupprimerProduit->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $reqSupprimerProduit->execute();
    
    
    $redir = "mesventes.php";
    header('Location: ' . $redir);
    ?>


