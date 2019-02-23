<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Page HTML -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mes commandes</title>
        <link rel="stylesheet" href="indexStyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <?php include("header.php"); ?>

    <div class="corps">
    <!-- Listing des produits, on prend les 10 derniers messages seulement pour un affichage plus clair-->
    <h1>Mes commandes</h1>

<?php
    include("connexionBDD.php");
    $reqcommande = $bdd->prepare("
     SELECT c.panier AS panier, c.prixtotal AS prixtotal, c.dateachat AS dateachat, c.idpaiement AS idpaiement, c.adresselivraison AS adresselivraison
     FROM commandes c, paniers p
     WHERE c.panier = p.idpanier
     AND p.utilisateur = :user
     ");
     $reqcommande->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
     $reqcommande->execute();
     
     while ($donnees = $reqcommande->fetch(PDO::FETCH_ASSOC)) {
         echo "<div class='commandes'>";
         echo "<p>Référence du payement: " . $donnees['idpaiement'] . "</p>";
         echo "<p>Date d'achat: " . $donnees['dateachat'] . "</p>";
         echo "<p>Prix total: " . $donnees['prixtotal'] . " €</p>";
         echo "<p>Adresse de livraison: " . $donnees['adresselivraison'] . "</p>";
         
        
                                 
         $reqproduit = $bdd->prepare("
              SELECT a.quantite, p.titre, p.description, p.idproduit
              FROM ajoutpanier a, produits p
              WHERE a.produit = p.idproduit
              AND a.panier = :panier
              ");
         $reqproduit->bindParam('panier', $donnees['panier'], PDO::PARAM_STR);
         $reqproduit->execute();
        
         while ($donnees_produit = $reqproduit->fetch(PDO::FETCH_ASSOC)) {
             echo "<p></p>";
             echo "<p><a href=\"produit.php?idproduit=" . $donnees_produit['idproduit'] . "\">" . $donnees_produit['titre'] . "</a></p>";
             echo "<p>Description: " . $donnees_produit['description'] . "</p>";
             echo "<p>Quantité: " . $donnees_produit['quantite'] . "</p>";
             echo "<hr>";
         }
         echo "<p></p>";
         echo "<p></p>";
         }
         echo "</div>";
?>
</div>
<div class="space"></div>
    <!-- Le pied de page -->

    <div class="footer">
        <p><a href="#">Nous contacter</a></p>
        <p><a href="#">À propos</a></p>
        <p><a href="#">Nos services</a></p>
        <p><a href="#">Politique</a></p>
        <p><a href="#">Charte</a></p>
        <p class="righr">&copy Copyrights Groupe 5</p>
    </div>

</body>

</html>
