<?php
    session_start();
    ?>
<!-- Page HTML -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mes ventes</title>
        <link rel="stylesheet" href="indexStyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>
    <?php include("header.php"); ?>

    <div class="corps">
    <!-- Listing des produits, on prend les 10 derniers messages seulement pour un affichage plus clair-->
    <h1>Mes ventes</h1>

    <?php
        include("connexionBDD.php");

        $req = $bdd->prepare("
         SELECT idproduit, titre, description, prix, quantite
         FROM Produits
         WHERE quantite > 0
         AND vendeur = :user
         ");
         $req->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
         $req->execute();
         
         while ($donnees = $req->fetch()) {
            $reqPhoto = $bdd->prepare("
                        SELECT photo
                        FROM photosproduit
                        WHERE produit = :p1
                        ");
            $reqPhoto->bindParam('p1', $donnees['idproduit'], PDO::PARAM_INT);
            $reqPhoto->execute();
            $donneesPhoto = $reqPhoto->fetch(PDO::FETCH_ASSOC);
            echo "<div class='ventes'>";
            echo "<a href=\"produit.php?idproduit=" . $donnees['idproduit'] . "\">";
            echo "<div class='photoproduit'><img src=\"photos_produits/" . $donneesPhoto['photo'] . "_mini\"></div>";
            echo "<p>" . $donnees['titre'] . "</p>";
            echo "<p>" . $donnees['description'] . "</p>";
            echo "<p>" . $donnees['prix'] . " €</p>";
            echo "<p>Quantité: " . $donnees['quantite'] . "</a></p>";
            echo "<p><a href=\"supprimerventes.php?idproduit=" . $donnees['idproduit'] . "\">supprimer</a></p>";
            echo "</div>";
        }
        $req->closeCursor();
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


