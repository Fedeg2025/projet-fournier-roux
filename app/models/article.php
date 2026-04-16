<?php

// =========================
// MODÈLE ARTICLE
// Ce fichier contient les fonctions
// liées aux articles et catégories
// =========================


// =========================
// REQUÊTES DE BASE
// Ces fonctions permettent de factoriser
// les éléments communs des requêtes article
// =========================
function getBaseArticleQuery()
{
    return "FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie";
}

function getBaseArticleSelect()
{
    return "SELECT 
                articles.id_article,
                articles.titre,
                articles.contenu,
                articles.date_publication,
                articles.id_utilisateur,
                articles.nom_fichier_image,
                utilisateurs.nom,
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories";
}


// =========================
// RÉCUPÉRATION DES ARTICLES
// =========================


// =========================
// RÉCUPÉRER TOUS LES ARTICLES
// Cette fonction retourne tous les articles
// triés par date de publication
// Paramètre :
// - $pdo : connexion à la base de données
// Retour : tableau des articles ou tableau vide si erreur
// =========================
function getAllArticles($pdo)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getAllArticles : ' . $e->getMessage());
        return [];
    }
}


// =========================
// RÉCUPÉRER LES DERNIERS ARTICLES
// Cette fonction retourne un nombre limité
// d’articles récents
// Paramètres :
// - $pdo : connexion à la base de données
// - $limit : nombre d’articles à récupérer
// Retour : tableau des articles ou tableau vide si erreur
// =========================
function getLatestArticles($pdo, $limit = 3)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC
               LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getLatestArticles : ' . $e->getMessage());
        return [];
    }
}


// =========================
// RÉCUPÉRER LES ARTICLES PLUS ANCIENS
// Cette fonction retourne les articles
// après un certain décalage
// Paramètres :
// - $pdo : connexion à la base de données
// - $offset : nombre d’articles à ignorer
// Retour : tableau des articles ou tableau vide si erreur
// =========================
function getOlderArticles($pdo, $offset = 3)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC
               LIMIT 100 OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getOlderArticles : ' . $e->getMessage());
        return [];
    }
}


// =========================
// RÉCUPÉRER LE DÉTAIL D’UN ARTICLE
// Cette fonction retourne le détail
// d’un article selon son identifiant
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : article ou null si erreur ou introuvable
// =========================
function getArticleDetailById($pdo, $articleId)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               WHERE articles.id_article = ?
               GROUP BY articles.id_article";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$articleId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getArticleDetailById : ' . $e->getMessage());
        return null;
    }
}


// =========================
// RÉCUPÉRER LES ARTICLES D’UNE CATÉGORIE
// Cette fonction retourne les articles
// associés à une catégorie
// Paramètres :
// - $pdo : connexion à la base de données
// - $categoryId : identifiant de la catégorie
// Retour : tableau des articles ou tableau vide si erreur
// =========================
function getArticlesByCategory($pdo, $categoryId)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               WHERE categorie.id_categorie = ?
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$categoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getArticlesByCategory : ' . $e->getMessage());
        return [];
    }
}


// =========================
// CRUD DES ARTICLES
// =========================


// =========================
// CRÉER UN ARTICLE
// Cette fonction enregistre un nouvel article
// Paramètres :
// - $pdo : connexion à la base de données
// - $title : titre de l’article
// - $content : contenu de l’article
// - $userId : identifiant de l’utilisateur
// Retour : true si succès, sinon false
// =========================
function createArticle($pdo, $title, $content, $userId)
{
    try {
        $sql = "INSERT INTO articles (titre, contenu, id_utilisateur) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$title, $content, $userId]);
    } catch (PDOException $e) {
        error_log('Erreur createArticle : ' . $e->getMessage());
        return false;
    }
}


// =========================
// METTRE À JOUR UN ARTICLE
// Cette fonction met à jour
// le titre et le contenu d’un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// - $title : titre de l’article
// - $content : contenu de l’article
// Retour : true si succès, sinon false
// =========================
function updateArticle($pdo, $articleId, $title, $content)
{
    try {
        $sql = "UPDATE articles SET titre = ?, contenu = ? WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$title, $content, $articleId]);
    } catch (PDOException $e) {
        error_log('Erreur updateArticle : ' . $e->getMessage());
        return false;
    }
}


// =========================
// METTRE À JOUR L’IMAGE D’UN ARTICLE
// Cette fonction enregistre le nom du fichier image
// directement dans la table articles
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// - $fileName : nom du fichier image
// Retour : true si succès, sinon false
// =========================
function updateArticleImage($pdo, $articleId, $fileName)
{
    try {
        $sql = "UPDATE articles SET nom_fichier_image = ? WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$fileName, $articleId]);
    } catch (PDOException $e) {
        error_log('Erreur updateArticleImage : ' . $e->getMessage());
        return false;
    }
}


// =========================
// SUPPRIMER UN ARTICLE
// Cette fonction supprime un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : true si succès, sinon false
// =========================
function deleteArticle($pdo, $articleId)
{
    try {
        $sql = "DELETE FROM articles WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$articleId]);
    } catch (PDOException $e) {
        error_log('Erreur deleteArticle : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER UN ARTICLE SIMPLE
// Cette fonction retourne un article
// sans jointures supplémentaires
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : article ou null si erreur ou introuvable
// =========================
function getArticleById($pdo, $articleId)
{
    try {
        $sql = "SELECT * FROM articles WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$articleId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getArticleById : ' . $e->getMessage());
        return null;
    }
}


// =========================
// GESTION DES CATÉGORIES
// =========================


// =========================
// AJOUTER UNE CATÉGORIE À UN ARTICLE
// Cette fonction associe une catégorie
// à un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// - $categoryId : identifiant de la catégorie
// Retour : true si succès, sinon false
// =========================
function addArticleCategory($pdo, $articleId, $categoryId)
{
    try {
        $sql = "INSERT INTO appartient (id_article, id_categorie) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$articleId, $categoryId]);
    } catch (PDOException $e) {
        error_log('Erreur addArticleCategory : ' . $e->getMessage());
        return false;
    }
}


// =========================
// SUPPRIMER LES CATÉGORIES D’UN ARTICLE
// Cette fonction supprime toutes les catégories
// liées à un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : true si succès, sinon false
// =========================
function deleteArticleCategories($pdo, $articleId)
{
    try {
        $sql = "DELETE FROM appartient WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$articleId]);
    } catch (PDOException $e) {
        error_log('Erreur deleteArticleCategories : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER LES IDENTIFIANTS DE CATÉGORIES
// Cette fonction retourne la liste
// des identifiants de catégories d’un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : tableau des identifiants ou tableau vide si erreur
// =========================
function getCategoryIdsByArticle($pdo, $articleId)
{
    try {
        $sql = "SELECT id_categorie FROM appartient WHERE id_article = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$articleId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log('Erreur getCategoryIdsByArticle : ' . $e->getMessage());
        return [];
    }
}