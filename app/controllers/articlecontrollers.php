<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/article.php';

$articles_recents = getLatestArticles($pdo, 3);
$articles_anciens = getOlderArticles($pdo, 3);

foreach ($articles_recents as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);

foreach ($articles_anciens as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);

require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/utilisateur/actualites.php';
require_once __DIR__ . '/../views/pages/footer.php';