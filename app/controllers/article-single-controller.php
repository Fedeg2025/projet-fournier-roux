<?php

// =========================
// CHARGEMENT DES MODÈLES
// =========================
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/media.php';


// =========================
// VALIDATION DE L'IDENTIFIANT
// =========================
$articleId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($articleId <= 0) {
    header('Location: index.php?page=articles');
    exit;
}


// =========================
// RÉCUPÉRATION DE L'ARTICLE
// =========================
$article = getArticleDetailById($pdo, $articleId);

if (!$article) {
    header('Location: index.php?page=articles');
    exit;
}


// =========================
// RÉCUPÉRATION DES MÉDIAS DE L’ARTICLE
// =========================
/**
 * Récupère les médias liés à l'article courant.
 */
$medias = getMediaByArticle($pdo, $articleId);

if (!is_array($medias)) {
    $medias = [];
}


// =========================
// AFFICHAGE DE LA PAGE
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/article-single.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';