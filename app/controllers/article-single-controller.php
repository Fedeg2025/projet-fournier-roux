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
// pour afficher le détail d’un article
// =========================
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/media.php';


// =========================
// VALIDATION DE L’IDENTIFIANT
// On vérifie que l’identifiant de l’article est présent
// et qu’il s’agit bien d’un nombre
// =========================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?page=articles');
    exit;
}

$id_article = (int) $_GET['id'];


// =========================
// RÉCUPÉRATION DE L’ARTICLE
// On récupère l’article demandé dans la base de données
// =========================
$article = getArticleDetailById($pdo, $id_article);

// Si l’article n’existe pas, retour vers la liste
if (!$article) {
    header('Location: index.php?page=articles');
    exit;
}


// =========================
// RÉCUPÉRATION DES MÉDIAS ASSOCIÉS
// Cette étape ajoute les médias liés à l’article
// =========================
$article['medias'] = getMediaByArticle($pdo, $article['id_article']);


// =========================
// AFFICHAGE DE LA PAGE ARTICLE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/article-single.php';
require_once BASE_PATH . '/app/views/pages/footer.php';