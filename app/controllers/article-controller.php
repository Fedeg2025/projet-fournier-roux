<?php

// =========================
// CHARGEMENT DU MODÈLE
// =========================
require_once BASE_PATH . '/app/models/article.php';


// =========================
// PARAMÈTRES DE RECHERCHE
// =========================
$searchTerm = trim($_GET['search'] ?? '');
$searchDate = trim($_GET['date'] ?? '');


// =========================
// PAGINATION
// =========================
$articlesPerPage = 2;
$currentPage = (int) ($_GET['p'] ?? 1);

if ($currentPage < 1) {
    $currentPage = 1;
}

$articleOffset = ($currentPage - 1) * $articlesPerPage;


// =========================
// RÉCUPÉRATION DES ARTICLES
// =========================
/**
 * Récupère la liste paginée des articles.
 */
if ($searchTerm !== '' || $searchDate !== '') {
    $totalArticles = countSearchArticles($pdo, $searchTerm, $searchDate);

    $articles = searchArticles(
        $pdo,
        $searchTerm,
        $searchDate,
        $articlesPerPage,
        $articleOffset
    );
} else {
    $totalArticles = countArticles($pdo);

    $articles = getPaginatedArticles(
        $pdo,
        $articlesPerPage,
        $articleOffset
    );
}


// =========================
// SÉCURITÉ SIMPLE
// =========================
if (!is_array($articles)) {
    $articles = [];
}


// =========================
// CALCUL PAGINATION
// =========================
$totalPages = ($totalArticles > 0)
    ? (int) ceil($totalArticles / $articlesPerPage)
    : 1;

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}


// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/news.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';