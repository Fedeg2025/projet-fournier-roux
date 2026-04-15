<?php

// =========================
// VÉRIFICATION DE L'AUTHENTIFICATION
// Cette page est réservée aux utilisateurs connectés
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}


// =========================
// CHARGEMENT DES MODÈLES
// Ce contrôleur utilise les modèles article et media
// pour récupérer les articles et leurs médias associés
// =========================
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/media.php';


// =========================
// RÉCUPÉRATION DE TOUS LES ARTICLES
// =========================
$articles = getAllArticles($pdo);


// =========================
// PAGINATION DES ARTICLES
// Cette partie permet d'afficher les articles
// sur plusieurs pages
// =========================
$articlesPerPage = 2;
$currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($currentPage < 1) {
    $currentPage = 1;
}

$totalArticles = count($articles);
$totalPages = (int) ceil($totalArticles / $articlesPerPage);
$articleOffset = ($currentPage - 1) * $articlesPerPage;

$articles = array_slice($articles, $articleOffset, $articlesPerPage);


// =========================
// AJOUT DES MÉDIAS À CHAQUE ARTICLE
// Cette boucle ajoute les médias liés
// à chaque article affiché
// =========================
foreach ($articles as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);


// =========================
// VARIABLES ATTENDUES PAR LA VUE
// =========================
$page_articles = $currentPage;
$total_pages_articles = $totalPages;


// =========================
// AFFICHAGE DE LA PAGE DES ARTICLES
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/news.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';