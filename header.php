<head>
	<link rel="stylesheet" type="text/css" href="headerStyle.css">
	<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
</head>
	<div class="header">
		<div class="avant_menu">
			<div class="logo">
				<a class="link" href="index.php">
					<h1 class="text">Marché en ligne</h1>
				</a>
			</div>

			<?php
			if (isset($_SESSION['login'])) {
				echo "<div class='menu_membre'>";
					echo "<a href='favoris.php'>Favoris</a>";
					echo "<a href='commande.php'>Commandes</a>";
	                echo "<a href='venteinformation.php'>Vendre</a>";
	                echo "<a href='mesventes.php'>Mes ventes</a>";
					echo "<a href='panier.php'>Panier</a>";
					echo "<a href='deconnecter.php'>Me déconnecter</a>";
				echo "</div>";


			}



	            else {
				echo "<div class='non_connecte'>";
					echo "<a href='inscription.php'>S'inscrire</a>";
					echo "<a href='connexion.php'>Se connecter</a>";
				echo "</div>";
				}
			?>
		</div>
		<div class="menu">
			<a href="index.php">Accueil</a>
			<?php
				include("connexionBDD.php");
				$reqCat = $bdd->prepare("SELECT * FROM categories");
				$reqCat->execute();
				while($resCat = $reqCat->fetch()){
								echo "<a href=\"index.php?cat=" .  $resCat['categorie'] . "\">" . $resCat['categorie'] . "</a>";
				}
			?>
		</div>
	</div>
