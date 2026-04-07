<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/article.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?page=articles');
    exit;
}

$id_article = (int) $_GET['id'];

$article = getArticleDetailById($pdo, $id_article);

if (!$article) {
    header('Location: index.php?page=articles');
    exit;
}

$article['medias'] = getMediaByArticle($pdo, $article['id_article']);

require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/utilisateur/article-single.php';
require_once __DIR__ . '/../views/pages/footer.php';