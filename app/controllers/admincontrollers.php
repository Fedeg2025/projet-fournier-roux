<?php

// Modèles nécessaires pour l'administration
require_once __DIR__ . '/../models/message.php';
require_once __DIR__ . '/../models/article.php';
require_once __DIR__ . '/../models/categorie.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/demande-suppression-compte.php';

$article_a_modifier = null;
$erreur = '';
$succes = '';

/**
 * Génère un jeton CSRF s'il n'existe pas encore.
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Vérifie que l'utilisateur connecté est bien administrateur.
 */
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

/**
 * Ajoute une image à un article si un fichier valide a été envoyé.
 */
function addImageToArticle($pdo, $id_article)
{
    if (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== 0 ||
        empty($_FILES['image']['tmp_name'])
    ) {
        return;
    }

    // Taille maximale : 2 Mo
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

    $dossier_televersement = __DIR__ . '/../../public/uploads/';

    if (!is_dir($dossier_televersement)) {
        mkdir($dossier_televersement, 0777, true);
    }

    $nom_original = basename($_FILES['image']['name']);
    $nom_securise = preg_replace('/[^A-Za-z0-9._-]/', '_', $nom_original);
    $nom_fichier = uniqid() . '_' . $nom_securise;
    $chemin_cible = $dossier_televersement . $nom_fichier;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin_cible)) {
        createMedia($pdo, $nom_fichier, 'image');
        $id_media = $pdo->lastInsertId();
        linkMediaToArticle($pdo, $id_article, $id_media);
    }
}

/**
 * Vérifie les droits admin.
 */
requireAdmin();

/**
 * Section actuelle du back-office.
 * Si rien n'est donné dans l'URL, on ouvre "messages" par défaut.
 */
$section = $_GET['section'] ?? 'messages';

/**
 * Pour éviter des valeurs bizarres dans l'URL.
 */
$sections_autorisees = ['messages', 'contenus', 'utilisateurs'];

if (!in_array($section, $sections_autorisees, true)) {
    $section = 'messages';
}

/**
 * Suppression d'un message.
 */
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

/**
 * Traitement d'une demande de suppression de compte.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_delete_request'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $id_demande = (int) $_POST['process_delete_request'];
    $admin_id = $_SESSION['user']['id_utilisateur'];

    $requete_demande = $pdo->prepare("SELECT id_utilisateur FROM demandes_suppression_compte WHERE id_demande = ?");
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

/**
 * Refus d'une demande de suppression de compte.
 */
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

/**
 * Suppression d'un article.
 */
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

/**
 * Charger un article pour le modifier.
 * Exemple :
 * index.php?page=admin&section=contenus&edit_article=3
 */
if (isset($_GET['edit_article'])) {
    $id_article = (int) $_GET['edit_article'];
    $article_a_modifier = getArticleById($pdo, $id_article);

    // Si on modifie un article, on reste dans la section contenus
    $section = 'contenus';
}

/**
 * Création ou modification d'un article.
 */
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
            // Modification
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
                // Création
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

/**
 * Récupération des données nécessaires à l'administration.
 */
$messages = getAllMessages($pdo);
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

$categories = getAllCategories($pdo);
$utilisateurs = getAllUsers($pdo);
$demandes_suppression = getAllDeleteAccountRequests($pdo);

$categories_selectionnees = [];

if ($article_a_modifier) {
    $categories_selectionnees = getCategoryIdsByArticle($pdo, $article_a_modifier['id_article']);
}

/**
 * Affichage
 */
require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/admin/dashboard.php';
require_once __DIR__ . '/../views/pages/footer.php';