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
// CHARGEMENT DU MODÈLE
// Ce contrôleur utilise le modèle article
// pour afficher le détail d’un article
// =========================
require_once BASE_PATH . '/app/models/article.php';


// =========================
// VALIDATION DE L’IDENTIFIANT
// On vérifie que l’identifiant de l’article est présent
// et qu’il s’agit bien d’un nombre
// =========================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?page=articles');
    exit;
}

$articleId = (int) $_GET['id'];


// =========================
// RÉCUPÉRATION DE L’ARTICLE
// On récupère l’article demandé dans la base de données
// =========================
$article = getArticleDetailById($pdo, $articleId);

// Si l’article n’existe pas, retour vers la liste
if (!$article) {
    header('Location: index.php?page=articles');
    exit;
}


// =========================
// AFFICHAGE DE LA PAGE ARTICLE
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/article-single.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';