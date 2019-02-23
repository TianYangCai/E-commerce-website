<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    /* Connexion à la base de données */
    include("connexionBDD.php");
    $req = $bdd->prepare("
         SELECT *
         FROM produits
         WHERE titre = :titre
         AND vendeur = :vendeur");
         $req->bindParam('titre', $_POST['titre'], PDO::PARAM_STR);
         $req->bindParam('vendeur', $_POST['vendeur'], PDO::PARAM_STR);
         $req->execute();

         $res = $req->fetch(PDO::FETCH_ASSOC);

    //Si l'utilisateur a déjè créer ce produit, il va ajouter sur le quantité au lieu de créer un nouveau
    if($res){
        $reqquantite = $bdd->prepare("
             UPDATE produits SET quantite = quantite + :quantite
             WHERE titre = :titre
             AND vendeur = :vendeur");
             $reqquantite->bindParam('quantite', $_POST['quantite'], PDO::PARAM_STR);
             $reqquantite->bindParam('titre', $_POST['titre'], PDO::PARAM_STR);
             $reqquantite->bindParam('vendeur', $_POST['vendeur'], PDO::PARAM_STR);
             $reqquantite->execute();
    }else{
         $reqIdProduit = $bdd->prepare("
                                        SELECT MAX(idproduit) as newid
                                        FROM produits"
                                        );
         $reqIdProduit->execute();
         $resIdProduit = $reqIdProduit->fetch(PDO::FETCH_ASSOC);
         if(!$resIdProduit){
         $idProduit = 1;
         }else{
         $idProduit = $resIdProduit['newid'] + 1;
         }


         $reqnewproduit = $bdd -> prepare("INSERT INTO produits VALUES(:idproduit, :titre, :description, :prix, :quantite, :etat, :couleur, :matiere, :vendeur, :categorie)");
         $reqnewproduit->execute(array(
                             'idproduit' => $idProduit,
                             'titre' => $_POST['titre'],
                             'description' => $_POST['description'],
                             'prix' => $_POST['prix'],
                             'quantite' => $_POST['quantite'],
                             'etat' => $_POST['etat'],
                             'couleur' => $_POST['couleur'],
                             'matiere' => $_POST['matiere'],
                             'vendeur' => $_SESSION['login'],
                             'categorie' => $_POST['categorie']));

        define('TARGET', '/volsme/user1x/users/na18a005/public_html/');    // Repertoire cible
        define('MAX_SIZE', 100000);    // Taille max en octets du fichier
        define('WIDTH_MAX', 800);    // Largeur max de l'image en pixels
        define('HEIGHT_MAX', 800);    // Hauteur max de l'image en pixels

        // Tableaux de donnees
        $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
        $infosImg = array();
        $extension = '';
        $message = '';
        $nomImage = '';
        if( !is_dir(TARGET) ) {
          if( !mkdir(TARGET, 0755) ) {
            exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous disposiez des droits suffisants pour le faire ou créez le manuellement !');
          }
        }

        if(!empty($_POST))
        {
          // On verifie si le champ est rempli
          if( !empty($_FILES['photo']['name']) )
          {
            // Recuperation de l'extension du fichier
            $extension  = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

            // On verifie l'extension du fichier
            if(in_array(strtolower($extension),$tabExt))
            {
              // On recupere les dimensions du fichier
              $infosImg = getimagesize($_FILES['photo']['tmp_name']);

              // On verifie le type de l'image
              if($infosImg[2] >= 1 && $infosImg[2] <= 14)
              {
                // On verifie les dimensions et taille de l'image
                if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['photo']['tmp_name']) <= MAX_SIZE))
                {
                  // Parcours du tableau d'erreurs
                  if(isset($_FILES['photo']['error'])
                    && UPLOAD_ERR_OK === $_FILES['photo']['error'])
                  {
                    // On renomme le fichier
                    $nomImage = md5(uniqid()) .'.'. $extension;

                    // Si c'est OK, on teste l'upload
                    if(move_uploaded_file($_FILES['photo']['tmp_name'], TARGET.$nomImage))
                    {
                      $message = 'Upload réussi !';
                    }
                    else
                    {
                      // Sinon on affiche une erreur systeme
                      $message = 'Problème lors de l\'upload !';
                    }
                  }
                  else
                  {
                    $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                  }
                }
                else
                {
                  // Sinon erreur sur les dimensions et taille de l'image
                  $message = 'Erreur dans les dimensions de l\'image !';
                }
              }
              else
              {
                // Sinon erreur sur le type de l'image
                $message = 'Le fichier à uploader n\'est pas une image !';
              }
            }
            else
            {
              // Sinon on affiche une erreur pour l'extension
              $message = 'L\'extension du fichier est incorrecte !';
            }
          }
          else
          {
            // Sinon on affiche une erreur pour le champ vide
            $message = 'Veuillez remplir le formulaire svp !';
          }
        }

       $reqPhoto = $bdd -> prepare("INSERT INTO photosproduit VALUES(:idproduit, :titre, :url)");
       $reqPhoto->execute(array(
                           'idproduit' => $idProduit,
                           'titre' => $_POST['titre'] . "_photo",
                           'url' => TARGET.$nomImage
                           ));
    }
    $redir = "index.php";
    header('Location: ' . $redir);
?>
