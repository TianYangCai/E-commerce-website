<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connexionBDD.php");

$idPanier = $_GET['idpanier'];
$prixtotal = $_GET['prixtotal'];
    
if(isset($_SESSION['login'])){
    $login = $_SESSION['login'];
    
    /*Touver l'addresse de l'utilisateur*/
    $req = $bdd -> prepare("
           SELECT adresse
           FROM Utilisateurs
           WHERE login = :pl"
           );
    $req->bindParam('pl', $login, PDO::PARAM_STR);
    $req-> execute();
    
    $res = $req->fetch(PDO::FETCH_ASSOC);
    $address = $res['adresse'];
    
    /*On cherche idPaiement*/
    $reqIdPaiement = $bdd->prepare("
             SELECT MAX(idPaiement) as newid
             FROM Commandes"
             );
    $reqIdPaiement->execute();
    $resIdPaiement = $reqIdPaiement->fetch(PDO::FETCH_ASSOC);
    /*Si il n'y a pas aucun paiement, idPaiement est 1. Si il y a, on cherche le plus grande et plus 1*/
    if(!$resIdPaiement){
        $idPaiement = 1;
    }else{
        $idPaiement = $resIdPaiement['newid'] + 1;
    }
    
    
    $reqCommande = $bdd -> prepare("
       INSERT INTO Commandes VALUES(:idpanier, :prixtotal, NOW(), :idpaiement, :adresselivraison)");
   $reqCommande->execute(array(
                       'idpanier' => $idPanier,
                       'prixtotal' => $prixtotal,
                       'idpaiement' => $idPaiement,
                       'adresselivraison' => $address));
                                   
   $reqqutite = $bdd -> prepare("
          SELECT produit, quantite
          FROM ajoutpanier
          WHERE panier = :panier");
          $reqqutite->bindParam('panier', $idPanier, PDO::PARAM_STR);
          $reqqutite->execute();
          while ($donnees = $reqqutite->fetch(PDO::FETCH_ASSOC)) {
            $reqchangequtite = $bdd -> prepare("
                UPDATE produits SET quantite = quantite - :quanti WHERE idproduit = :produit");
           $reqchangequtite->execute(array(
                   'quanti' => $donnees['quantite'],
                   'produit' => $donnees['produit']));
            }
          }
                                   
                        
$redir = "panier.php";
header('Location: ' . $redir);
?>

