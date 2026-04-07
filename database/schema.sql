CREATE TABLE utilisateurs(
   id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(100) NOT NULL,
   email VARCHAR(255) NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   role ENUM('admin', 'utilisateur') NOT NULL,
   prenom VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(email)
);

CREATE TABLE articles(
   id_article INT AUTO_INCREMENT,
   titre VARCHAR(255) NOT NULL,
   contenu TEXT NOT NULL,
   date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_article),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

CREATE TABLE media(
   id_media INT AUTO_INCREMENT,
   nom_fichier VARCHAR(255) NOT NULL,
   date_upload DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   type_media ENUM('image', 'video', 'audio') NOT NULL,
   PRIMARY KEY(id_media)
);

CREATE TABLE messages(
   id_message INT AUTO_INCREMENT,
   prenom VARCHAR(100) NOT NULL,
   email VARCHAR(150) NOT NULL,
   nom VARCHAR(100) NOT NULL,
   message TEXT NOT NULL,
   date_envoi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   civilite ENUM('M', 'Mme', 'Autre') NOT NULL,
   objet VARCHAR(255) NOT NULL,
   id_utilisateur INT,
   PRIMARY KEY(id_message),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

CREATE TABLE categorie(
   id_categorie INT AUTO_INCREMENT,
   nom VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_categorie)
);

CREATE TABLE contient(
   id_article INT,
   id_media INT,
   PRIMARY KEY(id_article, id_media),
   FOREIGN KEY(id_article) REFERENCES articles(id_article),
   FOREIGN KEY(id_media) REFERENCES media(id_media)
);

CREATE TABLE appartient(
   id_article INT,
   id_categorie INT,
   PRIMARY KEY(id_article, id_categorie),
   FOREIGN KEY(id_article) REFERENCES articles(id_article),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);

CREATE TABLE demandes_suppression_compte (
   id_demande INT AUTO_INCREMENT,
   id_utilisateur INT NOT NULL,
   motif TEXT NULL,
   statut ENUM('en_attente', 'traitee', 'refusee') NOT NULL DEFAULT 'en_attente',
   date_demande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   date_traitement DATETIME NULL,
   traitee_par INT NULL,
   commentaire_admin TEXT NULL,
   PRIMARY KEY (id_demande),
   FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
   FOREIGN KEY (traitee_par) REFERENCES utilisateurs(id_utilisateur)
);