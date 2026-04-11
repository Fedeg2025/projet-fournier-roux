<?php

// =========================
// SÉCURITÉ
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// =========================
// MODÈLES
// =========================
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/media.php';

// =========================
// VALIDATION ID
// =========================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?page=articles');
    exit;
}

$id_article = (int) $_GET['id'];

// =========================
// RÉCUPÉRATION ARTICLE
// =========================
$article = getArticleDetailById($pdo, $id_article);

if (!$article) {
    header('Location: index.php?page=articles');
    exit;
}

$article['medias'] = getMediaByArticle($pdo, $article['id_article']);

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/article-single.php';
require_once BASE_PATH . '/app/views/pages/footer.php';