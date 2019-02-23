<html>
	<head>
		<meta charset="UTF-8">
		<title>Inscription</title>
		<link rel="stylesheet" href="indexStyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	</head>
	<body>
		<?php 
			include("header.php");
			if(isset($_GET['success'])){ /*Si success est set on a pas pu se connecter*/
				?>
				<script type="text/javascript">
				    alert("Login ou mot de passe erroné");
				</script>
		<?php
			}
		?>
		<div class="connexion">

			<form method="post" action="connecter.php">
					<h1>Connexion</h1><br><br>
					<i class="material-icons">account_circle</i>
					<input type="text" name="login" placeholder="Login"><br><br>
					<i class="material-icons">lock</i>
					<input type="password" name="password" placeholder="Mot de passe"><br><br>
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
