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

/**
 * Retourne la partie commune FROM et JOIN
 * utilisée dans les requêtes liées aux articles.
 */
function getBaseArticleQuery()
{
    return "FROM articles
            JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id_utilisateur
            LEFT JOIN appartient ON articles.id_article = appartient.id_article
            LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie";
}

/**
 * Retourne la partie commune SELECT
 * utilisée dans les requêtes liées aux articles.
 */
function getBaseArticleSelect()
{
    return "SELECT 
                articles.id_article,
                articles.titre,
                articles.contenu,
                articles.date_publication,
                articles.id_utilisateur,
                utilisateurs.nom,
                utilisateurs.prenom,
                GROUP_CONCAT(categorie.nom SEPARATOR ', ') AS categories";
}


// =========================
// RÉCUPÉRATION DES ARTICLES
// =========================


// =========================
// RÉCUPÉRER TOUS LES ARTICLES
// Retourne tous les articles triés par date
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
// Retourne un nombre limité d’articles récents
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
// Retourne les articles après un décalage
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
// Retourne le détail d’un article
// selon son identifiant
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
// Retourne les articles associés
// à une catégorie
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
// PAGINATION DES ARTICLES
// Retourne les articles d’une page donnée
// =========================
function getPaginatedArticles($pdo, $limit, $offset)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC
               LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getPaginatedArticles : ' . $e->getMessage());
        return [];
    }
}


// =========================
// COMPTER LE NOMBRE TOTAL D’ARTICLES
// Utile pour la pagination
// =========================
function countArticles($pdo)
{
    try {
        $sql = "SELECT COUNT(*) FROM articles";
        $stmt = $pdo->query($sql);

        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Erreur countArticles : ' . $e->getMessage());
        return 0;
    }
}


// =========================
// RECHERCHER DES ARTICLES
// Recherche simple par titre et date
// Les deux champs sont optionnels
// =========================
function searchArticles($pdo, $searchTerm = '', $searchDate = '', $limit = 10, $offset = 0)
{
    try {
        $sql = getBaseArticleSelect() . " " .
               getBaseArticleQuery() . "
               WHERE (:searchTerm = '' OR articles.titre LIKE :searchLike)
               AND (:searchDate = '' OR DATE(articles.date_publication) = :searchDate)
               GROUP BY articles.id_article
               ORDER BY articles.date_publication DESC
               LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':searchLike', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->bindValue(':searchDate', $searchDate, PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur searchArticles : ' . $e->getMessage());
        return [];
    }
}


// =========================
// COMPTER LES RÉSULTATS DE RECHERCHE
// Utile pour la pagination du moteur
// de recherche
// =========================
function countSearchArticles($pdo, $searchTerm = '', $searchDate = '')
{
    try {
        $sql = "SELECT COUNT(DISTINCT articles.id_article)
                FROM articles
                LEFT JOIN appartient ON articles.id_article = appartient.id_article
                LEFT JOIN categorie ON appartient.id_categorie = categorie.id_categorie
                WHERE (:searchTerm = '' OR articles.titre LIKE :searchLike)
                AND (:searchDate = '' OR DATE(articles.date_publication) = :searchDate)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':searchLike', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->bindValue(':searchDate', $searchDate, PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Erreur countSearchArticles : ' . $e->getMessage());
        return 0;
    }
}


// =========================
// CRUD DES ARTICLES
// =========================


// =========================
// CRÉER UN ARTICLE
// Enregistre un nouvel article
// et retourne son identifiant
// =========================
function createArticle($pdo, $title, $content, $userId)
{
    try {
        $sql = "INSERT INTO articles (titre, contenu, id_utilisateur) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $userId]);

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur createArticle : ' . $e->getMessage());
        return false;
    }
}


// =========================
// METTRE À JOUR UN ARTICLE
// Met à jour le titre et le contenu
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
// SUPPRIMER UN ARTICLE
// Supprime un article
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
// Retourne un article sans jointures
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
// Associe une catégorie à un article
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
// Supprime toutes les catégories
// liées à un article
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
// METTRE À JOUR LES CATÉGORIES D’UN ARTICLE
// Supprime les anciennes catégories
// puis ajoute les nouvelles
// =========================
function updateArticleCategories($pdo, $articleId, $categoryIds = [])
{
    try {
        deleteArticleCategories($pdo, $articleId);

        if (!empty($categoryIds)) {
            foreach ($categoryIds as $categoryId) {
                addArticleCategory($pdo, $articleId, $categoryId);
            }
        }

        return true;
    } catch (PDOException $e) {
        error_log('Erreur updateArticleCategories : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER LES IDENTIFIANTS DE CATÉGORIES
// Retourne les identifiants des catégories
// d’un article
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