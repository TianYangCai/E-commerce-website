<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    /* Connexion à la base de données */
    include("connexionBDD.php");
    
    
    $idProduit = $_POST['idproduit'];
    $idPanier = $_POST['idpanier'];
    $quantite = $_POST['quantite'];
    
    $reqquantite = $bdd -> prepare("
           SELECT quantite
           FROM produits
           WHERE idproduit = :idproduit"
           );
    $reqquantite->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $reqquantite-> execute();
    
    $resquantite = $reqquantite->fetch(PDO::FETCH_ASSOC);
    $quantiteMAX = $resquantite['quantite'];
    
    if ($quantite>$quantiteMAX){
        $redir = "panier.php?success=0";
    }else{
    $reqModifierQuantite = $bdd->prepare("
     UPDATE ajoutpanier
     SET quantite = :quant
     WHERE panier = :idpanier AND produit = :idproduit;"
            );
    $reqModifierQuantite->bindParam('idproduit', $idProduit, PDO::PARAM_STR);
    $reqModifierQuantite->bindParam('idpanier', $idPanier, PDO::PARAM_STR);
    $reqModifierQuantite->bindParam('quant', $quantite, PDO::PARAM_STR);
    $reqModifierQuantite->execute();
    $redir = "panier.php";
    }
    header('Location: ' . $redir);
?>

