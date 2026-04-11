<?php

// =========================
// REQUÊTE DE BASE
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
// ARTICLES
// =========================

// Tous les articles
function getAllArticles($pdo)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC";

    return $pdo->query($sql)->fetchAll();
}

// Derniers articles
function getLatestArticles($pdo, $limit = 3)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC
           LIMIT :limite";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Articles anciens
function getOlderArticles($pdo, $offset = 3)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           ORDER BY articles.date_publication DESC
           LIMIT 100 OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Détail article
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

// Articles par catégorie
function getArticlesByCategory($pdo, $id_categorie)
{
    $sql = getBaseArticleSelect() . " " .
           getBaseArticleQuery() . "
           GROUP BY articles.id_article
           HAVING FIND_IN_SET(
               (SELECT nom FROM categorie WHERE id_categorie = ?),
               categories
           )
           ORDER BY articles.date_publication DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_categorie]);
    return $stmt->fetchAll();
}

// =========================
// CRUD
// =========================

function createArticle($pdo, $titre, $contenu, $id_utilisateur)
{
    $sql = "INSERT INTO articles (titre, contenu, id_utilisateur) VALUES (?, ?, ?)";
    return $pdo->prepare($sql)->execute([$titre, $contenu, $id_utilisateur]);
}

function updateArticle($pdo, $id_article, $titre, $contenu)
{
    $sql = "UPDATE articles SET titre = ?, contenu = ? WHERE id_article = ?";
    return $pdo->prepare($sql)->execute([$titre, $contenu, $id_article]);
}

function deleteArticle($pdo, $id_article)
{
    $sql = "DELETE FROM articles WHERE id_article = ?";
    return $pdo->prepare($sql)->execute([$id_article]);
}

function getArticleById($pdo, $id_article)
{
    $sql = "SELECT * FROM articles WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetch();
}

// =========================
// CATÉGORIES
// =========================

function addArticleCategory(PDO $pdo, int $id_article, int $id_categorie): bool
{
    $sql = "INSERT INTO appartient (id_article, id_categorie) VALUES (?, ?)";
    return $pdo->prepare($sql)->execute([$id_article, $id_categorie]);
}

function deleteArticleCategories(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM appartient WHERE id_article = ?";
    return $pdo->prepare($sql)->execute([$id_article]);
}

function getCategoryIdsByArticle(PDO $pdo, int $id_article): array
{
    $sql = "SELECT id_categorie FROM appartient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// =========================
// MÉDIAS (UNIQUEMENT LIEN)
// =========================

function deleteArticleMedia(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM contient WHERE id_article = ?";
    return $pdo->prepare($sql)->execute([$id_article]);
}