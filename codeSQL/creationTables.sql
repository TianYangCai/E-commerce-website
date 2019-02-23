CREATE TYPE ETATS AS ENUM ('Bon état', 'Neuf', 'Comme Neuf', 'Reconditionné');
CREATE TYPE COULEURS AS ENUM ('ROUGE', 'BLANC', 'NOIR', 'VERT', 'BLEU', 'MULTICOLORE', 'JAUNE');
CREATE TYPE TYPES_LIVRAISON AS ENUM('Relais', 'Domicile', 'Remise en main propre');
CREATE TYPE SEXES AS ENUM ('H', 'F');

CREATE TABLE Categories(
	categorie VARCHAR PRIMARY KEY
);

CREATE TABLE MatieresProduit(
	matiere VARCHAR PRIMARY KEY
);

CREATE TABLE Utilisateurs(
	login VARCHAR PRIMARY KEY,
	nom VARCHAR NOT NULL,
	prenom VARCHAR NOT NULL,
	mdp VARCHAR NOT NULL,
	email VARCHAR NOT NULL,
	adresse VARCHAR,
	codePostal NUMERIC(5),
	ville VARCHAR,
	sexe SEXES NOT NULL,
	age INT NOT NULL,
	CHECK(age > 0 AND age < 120),
	UNIQUE(email)
);

CREATE TABLE Produits(
	idProduit INT PRIMARY KEY,
	titre VARCHAR NOT NULL,
	description TEXT,
	prix REAL NOT NULL,
	quantite INT NOT NULL,
	etat ETATS,
	couleur COULEURS,
	matiere VARCHAR NOT NULL,
	vendeur VARCHAR NOT NULL,
	categorie VARCHAR NOT NULL,
	CHECK(prix > 0),
	CHECK(quantite > 0),
FOREIGN KEY(matiere) REFERENCES MatieresProduit(matiere),
	FOREIGN KEY(vendeur) REFERENCES Utilisateurs(login),
	FOREIGN KEY(categorie) REFERENCES Categories(categorie)
);

CREATE TABLE InfosLivraison(
	typeLivraison TYPES_LIVRAISON NOT NULL,
	lieuLivraison VARCHAR NOT NULL,
	produit INT NOT NULL,
	prixLivraison REAL NOT NULL,
	PRIMARY KEY(typeLivraison, lieuLivraison, produit),
	FOREIGN KEY(produit) REFERENCES Produits(idProduit)
);

CREATE TABLE photosProduit(
	produit INT NOT NULL,
	titrePhoto VARCHAR NOT NULL,
	photo VARCHAR NOT NULL, --lien vers la photo
	PRIMARY KEY(produit, titrePhoto),
	FOREIGN KEY(produit) REFERENCES Produits(idProduit)
);

CREATE TABLE Favoris(
	utilisateur VARCHAR NOT NULL,
	produit INT NOT NULL,
	PRIMARY KEY(utilisateur, produit),
	FOREIGN KEY(utilisateur) REFERENCES Utilisateurs(login),
	FOREIGN KEY(produit) REFERENCES Produits(idProduit)
);

CREATE TABLE Paniers(
	idPanier INT PRIMARY KEY,
	dateCreation TIMESTAMP NOT NULL,
	utilisateur VARCHAR NOT NULL,
	FOREIGN KEY(utilisateur) REFERENCES Utilisateurs(login)
);

CREATE TABLE AjoutPanier(
	panier INT NOT NULL,
	produit INT NOT NULL,
	quantite INT NOT NULL,
	PRIMARY KEY(panier, produit),
	FOREIGN KEY(panier) REFERENCES Paniers(idPanier),
	FOREIGN KEY(produit) REFERENCES Produits(idProduit)
);

CREATE TABLE Commandes(
	panier INT PRIMARY KEY,
	prixTotal REAL NOT NULL,
	dateAchat TIMESTAMP NOT NULL,
	idPaiement INT UNIQUE NOT NULL,
	adresseLivraison VARCHAR NOT NULL, --si l'acheteur veut une remise en main propre, mettre l’adresse du vendeur
	FOREIGN KEY(panier) REFERENCES Paniers(idPanier)
);

GRANT SELECT ON Produits TO public;

CREATE VIEW paniersNonSoldes AS
SELECT idpanier, utilisateur
FROM paniers
EXCEPT
SELECT c.panier, p.utilisateur
FROM commandes c, paniers p
WHERE p.idpanier = c.panier;


CREATE VIEW ventesUtilisateur AS
	SELECT U.login, sum(Prod.prix * AP.quantite)
	FROM Commandes C, Utilisateurs U, Paniers Pan, AjoutPanier AP, Produits Prod
	WHERE C.panier = Pan.idPanier
		AND Pan.idPanier = AP.panier
		AND AP.produit = Prod.idProduit
		AND Prod.vendeur = U.login
	GROUP BY U.login;

CREATE VIEW prixPaniers AS
	SELECT Pan.idPanier, sum(Prod.prix*AP.quantite)
	FROM Produits Prod 
	JOIN AjoutPanier AP 
	ON Prod.idProduit = AP.produit
	JOIN Paniers Pan
	ON AP.panier = Pan.idPanier
	GROUP BY Pan.idPanier;

CREATE VIEW achatsUtilisateurs AS
	SELECT U.login, Prod.titre, Prod.prix, AP.quantite
	FROM Utilisateurs U, Produits Prod, Paniers Pan, AjoutPanier AP, Commandes C
	WHERE U.login = Pan.utilisateur
		AND Pan.idPanier = AP.panier
		AND AP.produit = Prod.idProduit
		AND C.panier = Pan.idPanier;

CREATE VIEW produitsDisponibles AS --affiche seulement les articles disponibles (donc moins ceux passés en commande)
	SELECT Prod.idProduit, Prod.quantite - COALESCE(sum(AP.quantite),0) AS quantiteRestante
	FROM
	Produits Prod LEFT JOIN
		(AjoutPanier AP JOIN
			(Paniers Pan JOIN
				Commandes C
				ON Pan.idPanier = C.panier)
			ON AP.panier = Pan.idPanier)
		ON Prod.idProduit = AP.produit
	GROUP BY Prod.idProduit;


--Ces groupes permettront d'afficher sur la gauche combien d'articles sont disponibles pour chaque type de couleur, matiere...
CREATE VIEW groupesMatieres AS
	SELECT matiere, count(idProduit)
	FROM Produits
	GROUP BY matiere;

CREATE VIEW groupesCouleurs AS
	SELECT couleur, count(idProduit)
	FROM Produits
	GROUP BY couleur;
