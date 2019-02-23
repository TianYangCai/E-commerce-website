<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Connexion à la base de données */
include("connexionBDD.php");

$idProduit = $_GET['idproduit'];
//Récupération infos produit
$req = $bdd->prepare("
	SELECT titre, description, prix, quantite, etat, couleur, matiere, vendeur, categorie
	FROM Produits
	WHERE idproduit = :p1"
);
$req->bindParam('p1', $idProduit, PDO::PARAM_INT);
$req->execute();
$res = $req->fetch(); /*idproduit clé donc un seul tuple à récupérer */

$reqPhoto = $bdd->prepare("
  SELECT titrephoto, photo
  FROM photosproduit
  WHERE produit = :p1
  ");
$reqPhoto->bindParam('p1', $_GET['idproduit'], PDO::PARAM_INT);
$reqPhoto->execute();
$donneesPhoto = $reqPhoto->fetch();
?>





<!-- Page HTML -->
<!DOCTYPE html>
<html>
	<head>
        	<meta charset="utf-8" />
        	<link rel="stylesheet" href="indexStyle.css">
        	<title><?php echo $res['titre']; ?></title>
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
	<?php include("header.php"); ?>
	<div class="corps">
	    <div class="left">
	    	<?php echo "<div class='photo_un_produit'><img src=\"photos_produits/" . $donneesPhoto['photo'] . "\"></div>";
	  		?>
	  	</div>
	  	<div class"right">
			<div class="infoproduit_droite">
				<h1><?php echo $res['titre']; ?></h1>
				<p>Prix: <?php echo $res['prix']; ?> €</p>
				<p>Etat: <?php echo $res['etat']; ?></p>
				<p>Couleur: <?php echo $res['couleur']; ?></p>
				<p>Matière: <?php echo $res['matiere']; ?></p>
		        <p>Quantité: <?php echo $res['quantite']; ?></p>
			</div>

			<div class="description_produit">
				<h1>Description</h1>
				<p><?php echo $res['description']; ?></p>
			</div>
			<div class="achat_produit">

				<?php
					if(isset($_SESSION['login'])){
				?>


		        <form method='post' action='ajoutpanier.php'>
		        Quantité : <select name='quantite'> ";
		        <?php
		            for ($i=1 ; $i <= $res['quantite'] ; $i++){
		                echo "<option value='$i'> $i </option>";
		            }
		            ?>
		        </select>
		        <input class='submit_panier' type='submit' name='submit' value='Mettre dans mon panier'/>
		        <input type='hidden' name='idproduit' value= <?php echo $idProduit ?>>


				<div class="submit_favorie">
					<a href=<?php echo "\"ajoutfavoris.php?idproduit=" . $idProduit . "\">" ?>Ajouter à mes favoris</a>
				</div>
				<?php
				} else {
				?>
				<div class="submit_inscription">
					<a href="inscription.php">Inscrivez-vous !</a>
				</div>
				<div class="submit_connexion">
					<a href="connexion.php">Connectez-vous !</a>
				</div>
				<?php }
				?>
			</div>
		</div>
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

