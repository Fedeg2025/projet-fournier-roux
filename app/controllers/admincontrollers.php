<?php

// =========================
// SÉCURITÉ ADMIN
// =========================
function requireAdmin()
{
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    if ($_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?page=accueil');
        exit;
    }
}

requireAdmin();

// =========================
// MODÈLES
// =========================
require_once BASE_PATH . '/app/models/message.php';
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/categorie.php';
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/demande-suppression-compte.php';
require_once BASE_PATH . '/app/models/media.php';

// =========================
// VARIABLES
// =========================
$article_a_modifier = null;
$erreur = '';
$succes = '';

// =========================
// CSRF
// =========================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// =========================
// SECTION BACK-OFFICE
// =========================
$section = $_GET['section'] ?? 'messages';

$sections_autorisees = ['messages', 'contenus', 'utilisateurs'];

if (!in_array($section, $sections_autorisees, true)) {
    $section = 'messages';
}

// =========================
// CONFIRMATIONS DANS L’INTERFACE
// =========================
$confirm_delete = isset($_GET['confirm_delete']) ? (int) $_GET['confirm_delete'] : 0;
$confirm_delete_message = isset($_GET['confirm_delete_message']) ? (int) $_GET['confirm_delete_message'] : 0;

// =========================
// FONCTION UPLOAD IMAGE
// =========================
function addImageToArticle($pdo, $id_article)
{
    if (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== 0 ||
        empty($_FILES['image']['tmp_name'])
    ) {
        return;
    }

    $taille_max = 2 * 1024 * 1024;

    if ($_FILES['image']['size'] > $taille_max) {
        return;
    }

    $types_autorises = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type_mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($type_mime, $types_autorises, true)) {
        return;
    }

    $dossier = BASE_PATH . '/public/uploads/';

    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    $nom = uniqid() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES['image']['name']));
    $chemin = $dossier . $nom;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin)) {
        createMedia($pdo, $nom, 'image');
        $id_media = $pdo->lastInsertId();
        linkMediaToArticle($pdo, $id_article, $id_media);
    }
}

// =========================
// SUPPRESSION D’UN MESSAGE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $id_message = (int) $_POST['delete'];
    deleteMessage($pdo, $id_message);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=messages');
    exit;
}

// =========================
// TRAITEMENT D’UNE DEMANDE DE SUPPRESSION DE COMPTE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_delete_request'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $id_demande = (int) $_POST['process_delete_request'];
    $admin_id = $_SESSION['user']['id_utilisateur'];

    $requete_demande = $pdo->prepare('SELECT id_utilisateur FROM demandes_suppression_compte WHERE id_demande = ?');
    $requete_demande->execute([$id_demande]);
    $demande = $requete_demande->fetch();

    if ($demande) {
        anonymiseUser($pdo, $demande['id_utilisateur']);
    }

    markDeleteAccountRequestAsProcessed($pdo, $id_demande, $admin_id);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=utilisateurs');
    exit;
}

// =========================
// REFUS D’UNE DEMANDE DE SUPPRESSION DE COMPTE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refuse_delete_request'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $id_demande = (int) $_POST['refuse_delete_request'];
    $admin_id = $_SESSION['user']['id_utilisateur'];

    markDeleteAccountRequestAsRefused($pdo, $id_demande, $admin_id);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=utilisateurs');
    exit;
}

// =========================
// SUPPRESSION D’UN ARTICLE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $id_article = (int) $_POST['delete_article'];

    deleteArticleCategories($pdo, $id_article);
    deleteArticleMedia($pdo, $id_article);
    deleteArticle($pdo, $id_article);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=contenus');
    exit;
}

// =========================
// CHARGER UN ARTICLE POUR MODIFICATION
// =========================
if (isset($_GET['edit_article'])) {
    $id_article = (int) $_GET['edit_article'];
    $article_a_modifier = getArticleById($pdo, $id_article);
    $section = 'contenus';
}

// =========================
// CRÉATION / MODIFICATION D’UN ARTICLE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreur = 'Requête invalide (CSRF).';
    } else {
        $titre = trim($_POST['titre'] ?? '');
        $contenu = trim($_POST['contenu'] ?? '');
        $id_utilisateur = $_SESSION['user']['id_utilisateur'];
        $categories_formulaire = isset($_POST['categories']) ? $_POST['categories'] : [];

        if (mb_strlen($titre) < 3 || mb_strlen($titre) > 255) {
            $erreur = 'Le titre doit contenir entre 3 et 255 caractères.';
        } elseif (mb_strlen($contenu) < 10) {
            $erreur = 'Le contenu doit contenir au moins 10 caractères.';
        } else {
            if (isset($_POST['id_article']) && !empty($_POST['id_article'])) {
                $id_article = (int) $_POST['id_article'];

                updateArticle($pdo, $id_article, $titre, $contenu);

                deleteArticleCategories($pdo, $id_article);

                foreach ($categories_formulaire as $id_categorie) {
                    addArticleCategory($pdo, $id_article, $id_categorie);
                }

                addImageToArticle($pdo, $id_article);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: index.php?page=admin&section=contenus');
                exit;
            } else {
                createArticle($pdo, $titre, $contenu, $id_utilisateur);

                $id_article = $pdo->lastInsertId();

                foreach ($categories_formulaire as $id_categorie) {
                    addArticleCategory($pdo, $id_article, $id_categorie);
                }

                addImageToArticle($pdo, $id_article);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: index.php?page=admin&section=contenus');
                exit;
            }
        }
    }
}

// =========================
// DONNÉES NÉCESSAIRES À L’ADMINISTRATION
// =========================
$messages = getAllMessages($pdo);
$articles = getAllArticles($pdo);

$articles_par_page = 2;
$page_articles = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($page_articles < 1) {
    $page_articles = 1;
}

$total_articles = count($articles);
$total_pages_articles = (int) ceil($total_articles / $articles_par_page);
$offset_articles = ($page_articles - 1) * $articles_par_page;

$articles = array_slice($articles, $offset_articles, $articles_par_page);

foreach ($articles as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);

$categories = getAllCategories($pdo);
$utilisateurs = getAllUsers($pdo);
$demandes_suppression = getAllDeleteAccountRequests($pdo);

$categories_selectionnees = [];

if ($article_a_modifier) {
    $categories_selectionnees = getCategoryIdsByArticle($pdo, $article_a_modifier['id_article']);
}

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/admin/dashboard.php';
require_once BASE_PATH . '/app/views/pages/footer.php';