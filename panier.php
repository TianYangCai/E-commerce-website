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
        	<title>Mon panier</title>
        	<link rel="stylesheet" href="indexStyle.css">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
	<?php include("header.php"); ?>

    <div class="corps">
    <!-- Listing des produits, on prend les 10 derniers messages seulement pour un affichage plus clair-->
    	<h1>Mon panier</h1>
	
		<?php
		include("connexionBDD.php");
            if(isset($_GET['success'])){ /*Si success est set on a pas pu se connecter*/
                ?>
                <script type="text/javascript">
                alert("Ce produit est en rupture de stock.");
                </script>
                <?php
                    }
		$req = $bdd->prepare("
			SELECT p.idproduit AS idproduit, p.titre AS titre, p.description AS description, p.prix AS prix, AP.quantite AS quantite, AP.panier AS idpanier
			FROM Produits P, paniersnonsoldes PNS, ajoutpanier AP
			WHERE PNS.idpanier = AP.panier
			AND PNS.utilisateur = :user
			AND AP.produit = p.idproduit
			AND p.quantite > 0
			");
		$req->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
		$req->execute();

		while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
			$idPanier = $donnees['idpanier'];
			/*Requete et code relatif à l'affichage de la photo*/
			$reqPhoto = $bdd->prepare("
						SELECT photo
						FROM photosproduit
						WHERE produit = :p1
						");
			$reqPhoto->bindParam('p1', $donnees['idproduit'], PDO::PARAM_INT);
			$reqPhoto->execute();
			$donneesPhoto = $reqPhoto->fetch(PDO::FETCH_ASSOC);
			echo "<div class='panier'>";
			echo "<a href=\"produit.php?idproduit=" . $donnees['idproduit'] . "\">";
			echo "<div class='photoproduit'><img src=\"photos_produits/" . $donneesPhoto['photo'] . "_mini\"></div>";
			echo "<p>" . $donnees['titre'] . "</p>";
			echo "<p>Description:  " . $donnees['description'] . "</p>";
			echo "<p>Prix:  " . $donnees['prix'] . "€</p></a>";
			echo "<div class='modifQuantite'>";
				echo "<p>Quantité actuelle: " . $donnees['quantite'] . "</p>";

				/*Requete et code relatif au changement de quantité depuis le panier*/
				echo "<p> Modifier la quantité ?";
				echo "<form method='post' action='modifierQuantitePanier.php'>";
					echo "<input type='hidden' name='idproduit' value=" . $donnees['idproduit'] . ">";
					echo "<input type='hidden' name='idpanier' value=" . $idPanier . ">";
					echo "<select name='quantite'>";
					$reqQuant = $bdd->prepare("
						SELECT quantite
						FROM Produits
						WHERE idproduit = :p1
						");
					$reqQuant->bindParam('p1', $donnees['idproduit'], PDO::PARAM_INT);
					$reqQuant->execute();
					$donneesQuant = $reqQuant->fetch(PDO::FETCH_ASSOC);
					$i = 1;
		            for ($i=1 ; $i <= $donneesQuant['quantite'] ; $i++){
		            	echo "<option value='" . $i . "'>" . $i . "</option>";
					}
					echo "</select>";
                	echo "<input type='submit' name='submit' value='Modifier'/>";
				echo "</form></p>";
			echo "</div>";
	        echo "<p><a href=\"supprimerpanier.php?idproduit=" . $donnees['idproduit'] . "&idpanier=".$donnees['idpanier'] . "\">supprimer</a></p>";
			echo "</div>";
	    }
	    $req->closeCursor();

        ?>

	    <div class="total">
	    	<p> Sous total:
	    	<?php
			$reqPrixTotal = $bdd->prepare("
				SELECT PP.sum AS total
				FROM prixpaniers PP, paniersnonsoldes PNS
				WHERE PP.idpanier = PNS.idpanier
				AND PNS.utilisateur = :user
				");
			$reqPrixTotal->bindParam('user', $_SESSION['login'], PDO::PARAM_STR);
			$reqPrixTotal->execute();
			$resPrixTotal = $reqPrixTotal->fetch(PDO::FETCH_ASSOC);
	            	$prixTotal = $resPrixTotal['total'];
			echo $resPrixTotal['total'];
	    	?> €
	    	</p>
	    </div>


	    <?php
	    	$reqPanierExiste = $bdd->prepare("
            	SELECT idpanier, utilisateur
		FROM paniersNonSoldes
             	WHERE utilisateur = :p1"
             	);
	        
	        $reqPanierExiste->bindParam('p1', $_SESSION['login'], PDO::PARAM_STR);
	        $reqPanierExiste->execute();
	        $resPanierExiste = $reqPanierExiste->fetch(PDO::FETCH_ASSOC);
	        
	        if(!$resPanierExiste){ ?>
	        <?php }else{
	            $idPanier = $resPanierExiste['idpanier'];
	        }
	    ?>


		<?php if(isset($idPanier)){ ?>
		    <div class="commande">
		        <a href=<?php echo "\"ajoutcommande.php?idpanier=" . $idPanier . "&prixtotal=" . $prixTotal . "\">" ?>Acheter</a>
		    </div>
		<?php } ?>
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

