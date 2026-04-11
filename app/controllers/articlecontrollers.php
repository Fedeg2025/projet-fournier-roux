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
// pour récupérer les actualités et leurs médias associés
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
$articles_par_page = 2;
$page_articles = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($page_articles < 1) {
    $page_articles = 1;
}

$total_articles = count($articles);
$total_pages_articles = ceil($total_articles / $articles_par_page);
$offset_articles = ($page_articles - 1) * $articles_par_page;

$articles = array_slice($articles, $offset_articles, $articles_par_page);


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
// AFFICHAGE DE LA PAGE ACTUALITÉS
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/actualites.php';
require_once BASE_PATH . '/app/views/pages/footer.php';