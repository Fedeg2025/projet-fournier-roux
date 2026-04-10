<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/article.php';

$articles = getAllArticles($pdo);

$articles_par_page = 2;
$page_articles = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($page_articles < 1) {
    $page_articles = 1;
}

$total_articles = count($articles);
$total_pages_articles = ceil($total_articles / $articles_par_page);
$offset_articles = ($page_articles - 1) * $articles_par_page;

$articles = array_slice($articles, $offset_articles, $articles_par_page);

foreach ($articles as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);

require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/utilisateur/actualites.php';
require_once __DIR__ . '/../views/pages/footer.php';