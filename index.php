<?php
session_start();
?>
<!-- Page HTML -->
<!DOCTYPE html>
<html>
	<head>
        	<meta charset="utf-8" />
        	<title>Le marché en ligne</title>
        	<link rel="stylesheet" href="indexStyle.css">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>

	<?php include("header.php"); ?>

	<div class="cover"></div>
    <div class="corps" align="center">
    	<h1>Nos produits</h1>
    	<hr>
    <!-- Listing des produits, on prend les 10 derniers messages seulement pour un affichage plus clair-->

	<?php
	include("connexionBDD.php");
	if(isset($_GET['cat'])){
		$req = $bdd->prepare("
			SELECT idproduit, titre, description, prix, quantite
			FROM Produits
			WHERE quantite > 0
			AND categorie = :p1
			");
		$req->bindParam('p1', $_GET['cat'], PDO::PARAM_STR);
	} else {
	$req = $bdd->prepare("
		SELECT idproduit, titre, description, prix, quantite
		FROM Produits
		WHERE quantite > 0
		");
	}
	$req->execute();
        while ($donnees = $req->fetch()) {
			$reqPhoto = $bdd->prepare("
				SELECT titrephoto, photo
				FROM photosproduit
				WHERE produit = :p1
				");
			$reqPhoto->bindParam('p1', $donnees['idproduit'], PDO::PARAM_INT);
			$reqPhoto->execute();
			$donneesPhoto = $reqPhoto->fetch();
			echo "<div class='container'>";
			echo "<a class='nom' href=\"produit.php?idproduit=" . $donnees['idproduit'] . "\">";
			echo "<div class='photo'><img src=\"photos_produits/" . $donneesPhoto['photo'] . "_mini\"></div>";
			echo "<div class='titre'>" . $donnees['titre'] . "</div>";
			echo "<div class='prix'>". $donnees['prix'] . " €</div>";
			echo "</a>";
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


