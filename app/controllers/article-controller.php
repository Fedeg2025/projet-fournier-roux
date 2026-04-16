<?php

// =========================
// VÉRIFICATION DE LA CONNEXION
// Si l'utilisateur n'est pas connecté,
// on le redirige vers la page login
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}


// =========================
// CHARGEMENT DU MODÈLE ARTICLE
// =========================
require_once BASE_PATH . '/app/models/article.php';


// =========================
// RÉCUPÉRATION DE TOUS LES ARTICLES
// =========================
$articles = getAllArticles($pdo);

// Sécurité simple : si la fonction retourne autre chose qu'un tableau
if (!is_array($articles)) {
    $articles = [];
}


// =========================
// PAGINATION
// =========================
$articlesPerPage = 2;

// On récupère la page actuelle
$page_articles = isset($_GET['p']) ? (int) $_GET['p'] : 1;

// On évite les valeurs invalides
if ($page_articles < 1) {
    $page_articles = 1;
}

// Nombre total d’articles
$totalArticles = count($articles);

// Nombre total de pages
$total_pages_articles = ($totalArticles > 0) ? (int) ceil($totalArticles / $articlesPerPage) : 1;

// Si la page demandée dépasse le total, on revient à la dernière
if ($page_articles > $total_pages_articles) {
    $page_articles = $total_pages_articles;
}

// Calcul de l’offset
$articleOffset = ($page_articles - 1) * $articlesPerPage;

// On découpe le tableau pour n’afficher que les articles de la page
$articles = array_slice($articles, $articleOffset, $articlesPerPage);


// =========================
// AFFICHAGE DE LA PAGE
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/news.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';