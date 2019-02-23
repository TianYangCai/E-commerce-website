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
        	<title>Mes favoris</title>
        	<link rel="stylesheet" href="indexStyle.css">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
	<?php include("header.php"); ?>

    <div class="corps">
    	<h1>Mes produits favoris</h1>
		<?php
		include("connexionBDD.php");
            
		$req = $bdd->prepare("
			SELECT p.idproduit AS idproduit, p.titre AS titre, p.description AS description, p.prix AS prix
			FROM Produits p, favoris f
			WHERE f.produit = p.idproduit
				AND f.utilisateur = :user
				AND p.quantite > 0
			");
		$req->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
		$req->execute();
                             
                        
	    while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
	    	$reqPhoto = $bdd->prepare("
						SELECT photo
						FROM photosproduit
						WHERE produit = :p1
						");
			$reqPhoto->bindParam('p1', $donnees['idproduit'], PDO::PARAM_INT);
			$reqPhoto->execute();
			$donneesPhoto = $reqPhoto->fetch(PDO::FETCH_ASSOC);
			echo "<div class='favories'>";
			echo "<a href=\"produit.php?idproduit=" . $donnees['idproduit'] . "\">";
			echo "<div class='photoproduit'><img src=\"photos_produits/" . $donneesPhoto['photo'] . "_mini\"></div>";
			echo "<p>" . $donnees['titre'] . "</p>";
			echo "<p>" . $donnees['description'] . "</p";
			echo "<p>" . $donnees['prix'] . "</p></a>";
            echo "<p><a href=\"supprimerfavoris.php?idproduit=" . $donnees['idproduit'] . "\">supprimer</a></p>";
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

