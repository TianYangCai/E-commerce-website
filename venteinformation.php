<html>
    <head>
        <meta charset="UTF-8">
        <title>Mise en vente</title>
        <link rel="stylesheet" href="indexStyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
<?php
    session_start();
    include("header.php");
?>

    <script type="text/javascript">
    function surligne(champ, erreur)
    {
        if(erreur)
            champ.style.backgroundColor = "#fba";
        else
            champ.style.backgroundColor = "#98FB98";
    }
    function verifTitre(champ)
    {
        if(champ.value.length < 3 || champ.value.length > 30){
            surligne(champ, true);
            return false;
        } else {
            surligne(champ, false);
            return true;
        }
    }
    function verifDescription(champ)
    {
        if(champ.value.length > 300){
            surligne(champ, true);
            return false;
        } else {
            surligne(champ, false);
            return true;
        }
    }
    function verifQuantitePrix(champ)
    {
        if(champ.value <= 0){
            surligne(champ, true);
            return false;
        } else {
            surligne(champ, false);
            return true;
        }
    }
    function verifForm(form)
    {
        var titre = verifTitre(form.titre);
        var description = verifDescription(form.description);
        var prix = verifQuantitePrix(form.prix);
        var quantite = verifQuantitePrix(form.quantite);

        if(titre && description && prix && quantite){
            return true;
        } else {
            alert("Veuillez remplir correctement tous les champs");
            return false;
        }
    }

    </script>

    <div class="corps">

        <div class="vendre">
            <form method="post" action="venter.php" enctype="multipart/form-data" onsubmit="return verifForm(this)">
                <h1>Mise en vente</h1>
                <input type="text" name="titre" placeholder="Titre" onblur="verifTitre(this)"><br><br>
                <textarea name="description" placeholder="Description" style="width:200px;height:80px;" onblur="verifTitre(this)"></textarea><br><br>
                <input type="number" name="prix" placeholder="Prix" onblur="verifQuantitePrix(this)"><br><br>
                <input type="number" name="quantite" placeholder="Quantite" onblur="verifQuantitePrix(this)"><br><br>
                <label>Etat</label>
                <select name="etat">
		<?php
			include("connexionBDD.php");
			$reqEtats = $bdd->prepare("SELECT unnest(enum_range(NULL::etats))");
			$reqEtats->execute();			while($resEtats = $reqEtats->fetch()){
				echo "<option value=\"" .  $resEtats['unnest'] . "\">" . $resEtats['unnest'] . "</option>";
			}
		?>
                </select>
                <br><br>
                <label>Couleur</label>
                <select name="couleur">
		<?php
                        $reqCouleurs = $bdd->prepare("SELECT unnest(enum_range(NULL::couleurs))");
                        $reqCouleurs->execute();
                        while($resCouleurs = $reqCouleurs->fetch()){
                                echo "<option value=\"" .  $resCouleurs['unnest'] . "\">" . $resCouleurs['unnest'] . "</option>";
                        }
		?>
                </select>
                <br><br>
                <label>Matières</label>
                <select name="matiere">
		<?php
                        $reqMat = $bdd->prepare("SELECT * FROM matieresproduit");
                        $reqMat->execute();
                        while($resMat = $reqMat->fetch()){
                                echo "<option value=\"" .  $resMat['matiere'] . "\">" . $resMat['matiere'] . "</option>";
                        }
                ?>
                </select>
                <br><br>
                <label>Catégorie</label>
                <select name="categorie">
                <?php
                        $reqCat = $bdd->prepare("SELECT * FROM categories");
                        $reqCat->execute();
                        while($resCat = $reqCat->fetch()){
                                echo "<option value=\"" .  $resCat['categorie'] . "\">" . $resCat['categorie'] . "</option>";
                        }
                ?>
                </select>
                <br><br>
                <label>Photo</label>
                <input type="file" name="photo" />
                <br><br>
                <input class="submit" type="submit" value="Valider"><br>
                <input class="reset" type="reset" value="Effacer">
                </fieldset>
            </form>
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
