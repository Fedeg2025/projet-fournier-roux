<?php

// =========================
// MODÈLE ARTICLE
// Ce fichier contient les fonctions
// liées aux articles, catégories et médias
// =========================


// =========================
// REQUÊTE DE BASE
// Cette partie permet de factoriser
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
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories";
}


// =========================
// RÉCUPÉRATION DES ARTICLES
// =========================

// Récupérer tous les articles
function getAllArticles($pdo)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC";

    return $pdo->query($sql)->fetchAll();
}


// Récupérer les derniers articles
function getLatestArticles($pdo, $limit = 3)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC
           LIMIT :limite";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', (int) $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}


// Récupérer les articles plus anciens
function getOlderArticles($pdo, $offset = 3)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC
           LIMIT 100 OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}


// Récupérer le détail d’un article par son identifiant
function getArticleDetailById($pdo, $id_article)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           WHERE articles.id_article = ?
           GROUP BY articles.id_article";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);

    return $stmt->fetch();
}


// Récupérer les articles d’une catégorie
function getArticlesByCategory($pdo, $id_categorie)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           WHERE categorie.id_categorie = ?
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_categorie]);

    return $stmt->fetchAll();
}


// =========================
// CRUD DES ARTICLES
// =========================

// Créer un article
function createArticle($pdo, $titre, $contenu, $id_utilisateur)
{
    $sql = "INSERT INTO articles (titre, contenu, id_utilisateur) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$titre, $contenu, $id_utilisateur]);
}


// Mettre à jour un article
function updateArticle($pdo, $id_article, $titre, $contenu)
{
    $sql = "UPDATE articles SET titre = ?, contenu = ? WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$titre, $contenu, $id_article]);
}


// Supprimer un article
function deleteArticle($pdo, $id_article)
{
    $sql = "DELETE FROM articles WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_article]);
}


// Récupérer un article simple par son identifiant
function getArticleById($pdo, $id_article)
{
    $sql = "SELECT * FROM articles WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);

    return $stmt->fetch();
}


// =========================
// GESTION DES CATÉGORIES
// =========================

// Associer une catégorie à un article
function addArticleCategory(PDO $pdo, int $id_article, int $id_categorie): bool
{
    $sql = "INSERT INTO appartient (id_article, id_categorie) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_article, $id_categorie]);
}


// Supprimer toutes les catégories d’un article
function deleteArticleCategories(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM appartient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_article]);
}


// Récupérer les identifiants de catégories d’un article
function getCategoryIdsByArticle(PDO $pdo, int $id_article): array
{
    $sql = "SELECT id_categorie FROM appartient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


// =========================
// GESTION DU LIEN AVEC LES MÉDIAS
// Cette fonction supprime uniquement
// les relations entre l’article et ses médias
// =========================
function deleteArticleMedia(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM contient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_article]);
}