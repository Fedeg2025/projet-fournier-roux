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
// PARAMÈTRES DE RECHERCHE
// Recherche simple par titre et date
// =========================
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchDate = isset($_GET['date']) ? trim($_GET['date']) : '';


// =========================
// PAGINATION
// =========================
$articlesPerPage = 2;

// On récupère la page actuelle
$currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;

// On évite les valeurs invalides
if ($currentPage < 1) {
    $currentPage = 1;
}

// Calcul de l’offset
$articleOffset = ($currentPage - 1) * $articlesPerPage;


// =========================
// RÉCUPÉRATION DES ARTICLES
// Si une recherche est présente,
// on utilise la recherche paginée
// Sinon, on utilise la pagination normale
// =========================
if ($searchTerm !== '' || $searchDate !== '') {
    $totalArticles = countSearchArticles($pdo, $searchTerm, $searchDate);
    $articles = searchArticles($pdo, $searchTerm, $searchDate, $articlesPerPage, $articleOffset);
} else {
    $totalArticles = countArticles($pdo);
    $articles = getPaginatedArticles($pdo, $articlesPerPage, $articleOffset);
}


// =========================
// SÉCURITÉ SIMPLE
// Si la fonction retourne autre chose
// qu’un tableau, on force un tableau vide
// =========================
if (!is_array($articles)) {
    $articles = [];
}


// =========================
// CALCUL DU NOMBRE TOTAL DE PAGES
// =========================
$totalPages = ($totalArticles > 0) ? (int) ceil($totalArticles / $articlesPerPage) : 1;

// Si la page demandée dépasse le total,
// on revient à la dernière page
if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}


// =========================
// AFFICHAGE DE LA PAGE
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/news.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';