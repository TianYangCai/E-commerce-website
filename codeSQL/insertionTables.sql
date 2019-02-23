INSERT INTO matieresproduit(matiere) VALUES('Cuir');
INSERT INTO matieresproduit(matiere) VALUES('Tissus');
INSERT INTO matieresproduit(matiere) VALUES('Métal');
INSERT INTO matieresproduit(matiere) VALUES('Bois');
INSERT INTO matieresproduit(matiere) VALUES('Mélamine');

INSERT INTO Categories(categorie) VALUES('Mode');
INSERT INTO Categories(categorie) VALUES('High-tech');
INSERT INTO Categories(categorie) VALUES('Mobilier');

INSERT INTO utilisateurs
VALUES('ameunier', 'MEUNIER', 'Antoine', 'unHashTresLong', 'am@gmail.com', 'rue Vivenel', 60150, 'Villers', 'H', 22);
INSERT INTO utilisateurs
VALUES('Molibdenio', 'PDG', 'Confo', 'pswd', 'confo@gmail.com', 'rue Vivenel', 60200, 'Villers', 'H', 67);
INSERT INTO utilisateurs
VALUES('bbationo','CAI', 'Tianyang', 'jvousldiraipo', 'bb@gmail.com', 'rue de la boustifaille', 60200, 'Compicity', 'H', 23);


INSERT INTO produits (idProduit, titre, description, prix, quantite, etat, couleur, matiere, vendeur, categorie)
VALUES(20, 'Iphone 7', 'Un smartphone qui se ressemble beaucoup a sa version précédente, iPhone 6', 600, 39, 'Neuf', 'NOIR', 'Métal', 'Molibdenio', 'High-tech');
INSERT INTO produits
VALUES(21, 'Acer PC', 'ACER PC Portable Aspire ES1-132-C1RA 11,6 HD - RAM 2Go - Celeron N3350 - Stockage 32Go - Intel HD Graphics 500 - Windows 10 S - HDMI + USB 3.0 + 2xUSB 2.0 + LAN + Prise combo casque-microphone + Lecteur de carte SD/SDXC', 179, 20, 'Neuf', 'ROUGE', 'Métal', 'Molibdenio', 'High-tech');
INSERT INTO produits
VALUES(22, 'Axel Arigato - Sneaker', 'Chaussure occasionnel', 150, 10, 'Neuf', 'BLANC', 'Cuir', 'Molibdenio', 'Mode');
INSERT INTO produits
VALUES(23, 'PREMIUM BY JACK & JONES', 'Veste homme, taille S', 99, 6, 'Bon état', 'BLEU', 'Tissus', 'Molibdenio', 'Mode');
INSERT INTO produits
VALUES(26, 'Canapé 3 place', 'Assemblage : requis, 2 personnes

Type de mousse : polyuréthane, 28-30 kg/m3

Structure : Eucalyptus', 500, 50, 'Comme Neuf', 'ROUGE', 'Tissus', 'Molibdenio', 'Mobilier');
INSERT INTO produits
VALUES(27, 'Macaron', 'Chaise de salle à manger', 99, 9, 'Neuf', 'JAUNE', 'Tissus', 'Molibdenio', 'Mobilier');
INSERT INTO produits
VALUES(28, 'Bureau 4 tirroi JIMI', 'Bureau style scandinave, 4 tiroirs, 1 niche et pieds en pin', 100, 17, 'Comme Neuf', 'MULTICOLORE', 'Bois', 'Molibdenio', 'Mobilier');
INSERT INTO produits
VALUES(30, 'Chaussure Femme', 'Descriptif : Chaussure pointue Sexy Femmes Stilettos Escarpins haut talon ornée noeud papillon Sexy Femmes Stilettos Escarpins de soirée', 77, 12, 'Bon état', 'BLEU', 'Tissus', 'Molibdenio', 'Mode');
INSERT INTO produits
VALUES(31, 'Samsung Galaxy S10', 'Taille mémoire 1Gb, taille écran 7', 950, 10, 'Neuf', 'NOIR', 'Métal', 'Molibdenio', 'High-tech');
INSERT INTO produits
VALUES(32, 'Robe RoseGal', 'Robe Évasée en Dentelle Vintage à Épaules Dénudées - Rouge Vineux - Vin Rouge, taille S', 20, 20, 'Neuf', 'ROUGE', 'Tissus', 'Molibdenio', 'Mode');


INSERT INTO infoslivraison(typelivraison, lieulivraison, produit, prixlivraison)
VALUES('Domicile', 'amiens', 20, 12.90);

INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(20, 'Iphone 7_photo', '636x900-iphone-7-noir---vue-1-137069.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(21, 'Acer PC_photo', 'acer-pc-portable-aspire-es1-132-c1ra-11-6-led.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(22, 'Axel Arigato - Sneaker_photo', '05-01-2018_axelarigato_clean90embroideredbirdsneaker_whiteleather_28189_mo_1.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(23, 'PREMIUM BY JACK & JONES_photo', 'veste-homme-bleu.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(26, 'Canapé 3 place_photo', 'midnight-canape-3-places-velours.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(27, 'Macaron_photo', 'macaron-chaise-de-salle-a-manger-tissu-jaune-mou.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(28, 'Bureau 4 tirroi JIMI_photo', '6b30c9feca7f8fb90392e0ffc1ed1f41.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(30, 'Chaussure Femme_photo', 'Chaussures Femme Chaussure pointue Sexy Femmes Stilettos Escarpins haut talon orn233e noeud papillon Sexy Femmes Stilettos Escarpins de soir233e ROUGE    OAWESLE.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(31, 'Samsung Galaxy S10_photo', 'Samsung-Galaxy-S10-header-1800x1200.jpg');
INSERT INTO photosproduit(produit, titrephoto, photo)
VALUES(32, 'Robe RoseGal_photo', '1515369905204708429.jpg');




INSERT INTO favoris(utilisateur, produit)
VALUES('bbationo', 27);
INSERT INTO favoris(utilisateur, produit)
VALUES('ameunier', 28);
INSERT INTO favoris(utilisateur, produit)
VALUES('ameunier', 30);


INSERT INTO paniers(idpanier, datecreation, utilisateur)
VALUES(6, '2018-05-16 15:36:38', 'bbationo');
INSERT INTO paniers(idpanier, datecreation, utilisateur)
VALUES(2, '2018-10-16 22:39:38', 'ameunier');

INSERT INTO ajoutpanier
VALUES(6, 27, 2);
INSERT INTO ajoutpanier
VALUES(6, 28, 1);

INSERT INTO ajoutpanier
VALUES(2, 23, 1);
INSERT INTO ajoutpanier
VALUES(2, 26, 2);

INSERT INTO commandes(panier, prixtotal, dateachat, idpaiement, adresselivraison)
VALUES(6, 122, TIMESTAMP '2018-05-16 15:36:38', 98, 'rue de la boustifaille');

