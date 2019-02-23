<html>
	<head>
		<meta charset="UTF-8">
		<title>Inscription</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="indexStyle.css">
	</head>
	<body>
		<?php 
			include("header.php");
			if(isset($_GET['success'])){ /*Si success est set le login existe déjà*/
				?>
				<script type="text/javascript">
				    alert("Login ou email déjà utilisé");
				</script>
		<?php
			}
		?>

		<script type="text/javascript">
			function surligne(champ, erreur)
			{
			if(erreur)
			  champ.style.backgroundColor = "#fba";
			else
			  champ.style.backgroundColor = "#98FB98";
			}
			function verifNomPrenomlogin(champ)
			{
			   if(champ.value.length < 3 || champ.value.length > 15){ //On veut un login, nom et prénom et mdp compris entre 5 et 15 caractères
			      surligne(champ, true);
			      return false;
			   } else {
			      surligne(champ, false);
			      return true;
			   }
			}
			function verifAge(champ)
			{
			   if(champ.value < 18 || champ.value > 99){ //On veut un age entre 18 et 99 ans
			      surligne(champ, true);
			      return false;
			   } else {
			      surligne(champ, false);
			      return true;
			   }
			}
			function verifMail(champ)
			{
			   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; //regex pour un mail
			   if(!regex.test(champ.value)) {
			      surligne(champ, true);
			      return false;
			   } else {
			      surligne(champ, false);
			      return true;
			   }
			}
			function verifCp(champ)
			{
			   if(champ.value > 100000 || champ.value < 9999){ //On veut un age entre 18 et 99 ans
			      surligne(champ, true);
			      return false;
			   } else {
			      surligne(champ, false);
			      return true;
			   }
			}
			function verifForm(form)
			{
			   var nom = verifNomPrenomlogin(form.nom);
			   var prenom = verifNomPrenomlogin(form.prenom);
			   var login = verifNomPrenomlogin(form.login);
			   var mail = verifMail(form.mail);
			   var age = verifAge(form.age);
			   var cp = verifCp(form.codePostal);
			   var mdp = verifNomPrenomlogin(form.mdp);
			   
			   if(nom && prenom && login && mail && age && cp && mdp){
				return true;
			   } else {
				alert("Veuillez remplir correctement tous les champs");
				return false;
			   }
			}

		</script>


		<div class="inscription">
			<form method="post" action="inscrire.php" onsubmit="return verifForm(this)">
					<h1>Inscription</h1>
					<input type="text" name="nom" placeholder="Nom" onblur="verifNomPrenomlogin(this)"><br><br>
					<input type="text" name="prenom" placeholder="Prenom" onblur="verifNomPrenomlogin(this)"><br>
					<p>Sexe</p>
					<input type="radio" name="sexe" value="H" checked="checked">Homme<br>
					<input type="radio" name="sexe" value="F">Femme<br><br>
					<input type="number" name="age" placeholder="Age" onblur="verifAge(this)"><br><br>
					<input type="text" name="mail" placeholder="Email" onblur="verifMail(this)"><br><br>
					<input type="text" name="adresse" placeholder="Adresse"><br><br>
					<input type="number" name="codePostal" placeholder="Code Postal" onblur="verifCp(this)"><br><br>
					<input type="text" name="ville" placeholder="Ville"><br><br>
					<input type="text" name="login" placeholder="Login" onblur="verifNomPrenomlogin(this)"><br><br>
					<input type="password" name="mdp" placeholder="Mot de Passe" onblur="verifNomPrenomlogin(this)"><br><br>
					<input class="submit" type="submit" value="Valider"><br>
					<input class="reset" type="reset" value="Effacer">
			</form>
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
