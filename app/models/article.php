<?php

// Récupère tous les articles
function getAllArticles($pdo)
{
    $sql = "SELECT 
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories
            FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie
            GROUP BY articles.id_article
            ORDER BY articles.date_publication DESC";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Récupère les 3 derniers articles (ou autre limite)
function getLatestArticles($pdo, $limit = 3)
{
    $sql = "SELECT 
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories
            FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie
            GROUP BY articles.id_article
            ORDER BY articles.date_publication DESC
            LIMIT :limite";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', (int) $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Récupère les articles plus anciens (en sautant les plus récents)
function getOlderArticles($pdo, $offset = 3)
{
    $sql = "SELECT 
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories
            FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie
            GROUP BY articles.id_article
            ORDER BY articles.date_publication DESC
            LIMIT 100 OFFSET :decalage";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':decalage', (int) $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Récupère un article complet avec auteur et catégories
function getArticleDetailById($pdo, $id_article)
{
    $sql = "SELECT 
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories
            FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie
            WHERE articles.id_article = ?
            GROUP BY articles.id_article";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetch();
}

// Récupère les articles d’une catégorie
function getArticlesByCategory($pdo, $id_categorie)
{
    $sql = "SELECT 
                articles.*, 
                utilisateurs.nom, 
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories
            FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            INNER JOIN appartient a1 ON articles.id_article = a1.id_article
            LEFT JOIN appartient a2 ON articles.id_article = a2.id_article
            LEFT JOIN categorie ON a2.id_categorie = categorie.id_categorie
            WHERE a1.id_categorie = ?
            GROUP BY articles.id_article
            ORDER BY articles.date_publication DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_categorie]);
    return $stmt->fetchAll();
}

// Crée un nouvel article
function createArticle($pdo, $titre, $contenu, $id_utilisateur)
{
    $sql = "INSERT INTO articles (titre, contenu, id_utilisateur)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$titre, $contenu, $id_utilisateur]);
}

// Supprime un article
function deleteArticle($pdo, $id_article)
{
    $sql = "DELETE FROM articles WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_article]);
}

// Récupère un article par son ID
function getArticleById($pdo, $id_article)
{
    $sql = "SELECT * FROM articles WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetch();
}

// Modifie un article
function updateArticle($pdo, $id_article, $titre, $contenu)
{
    $sql = "UPDATE articles
            SET titre = ?, contenu = ?
            WHERE id_article = ?";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$titre, $contenu, $id_article]);
}

// Ajoute une relation entre un article et une catégorie
function addArticleCategory(PDO $pdo, int $id_article, int $id_categorie): bool
{
    $sql = "INSERT INTO appartient (id_article, id_categorie) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_article, $id_categorie]);
}

// Supprime toutes les catégories d’un article
function deleteArticleCategories(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM appartient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_article]);
}

// Supprime tous les médias liés à un article
function deleteArticleMedia(PDO $pdo, int $id_article): bool
{
    $sql = "DELETE FROM contient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_article]);
}

// Récupère les IDs des catégories liées à un article
function getCategoryIdsByArticle(PDO $pdo, int $id_article): array
{
    $sql = "SELECT id_categorie FROM appartient WHERE id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Ajoute un média
function createMedia($pdo, $nom_fichier, $type_media = 'image')
{
    $sql = "INSERT INTO media (nom_fichier, type_media)
            VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom_fichier, $type_media]);
}

// Lie un média à un article
function linkMediaToArticle($pdo, $id_article, $id_media)
{
    $sql = "INSERT INTO contient (id_article, id_media)
            VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_article, $id_media]);
}

// Récupère les médias d’un article
function getMediaByArticle($pdo, $id_article)
{
    $sql = "SELECT media.*
            FROM media
            INNER JOIN contient ON media.id_media = contient.id_media
            WHERE contient.id_article = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetchAll();
}