<?php

// =========================
// VÉRIFICATION DES DROITS ADMINISTRATEUR
// Cette fonction protège l’accès au back-office
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
// CHARGEMENT DES MODÈLES
// Ces modèles sont utilisés dans le back-office
// =========================
require_once BASE_PATH . '/app/models/message.php';
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/categorie.php';
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/media.php';


// =========================
// INITIALISATION DES VARIABLES
// Ces variables sont utilisées dans la vue admin
// =========================
$article_a_modifier = null;
$erreur = '';
$succes = '';


// =========================
// GÉNÉRATION DU TOKEN CSRF
// Le token est créé s’il n’existe pas encore
// =========================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// =========================
// CHOIX DE LA SECTION DU BACK-OFFICE
// Cette variable permet d’afficher la bonne zone
// =========================
$section = $_GET['section'] ?? 'messages';

$sections_autorisees = ['messages', 'contenus', 'utilisateurs'];

if (!in_array($section, $sections_autorisees, true)) {
    $section = 'messages';
}


// =========================
// CONFIRMATIONS D’ACTIONS DANS L’INTERFACE
// Ces variables permettent d’afficher des états visuels
// =========================
$confirm_delete = isset($_GET['confirm_delete']) ? (int) $_GET['confirm_delete'] : 0;
$confirm_delete_message = isset($_GET['confirm_delete_message']) ? (int) $_GET['confirm_delete_message'] : 0;


// =========================
// AJOUT D’UNE IMAGE À UN ARTICLE
// Cette fonction vérifie le fichier puis enregistre le média
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
// Cette partie supprime un message du formulaire admin
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
// SUPPRESSION D’UN ARTICLE
// Cette action supprime l’article et ses relations
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
// CHARGEMENT D’UN ARTICLE À MODIFIER
// Cette partie récupère l’article à éditer
// =========================
if (isset($_GET['edit_article'])) {
    $id_article = (int) $_GET['edit_article'];
    $article_a_modifier = getArticleById($pdo, $id_article);
    $section = 'contenus';
}


// =========================
// CRÉATION OU MODIFICATION D’UN ARTICLE
// Cette partie traite le formulaire d’article
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

            // Modification d’un article existant
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
            }

            // Création d’un nouvel article
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


// =========================
// RÉCUPÉRATION DES DONNÉES D’ADMINISTRATION
// Ces données sont nécessaires pour afficher le tableau de bord
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


// =========================
// GESTION SIMPLE DES UTILISATEURS
// Recherche, filtre alphabétique et pagination
// =========================
$utilisateurs = getAllUsers($pdo);

$search = trim($_GET['search'] ?? '');
$letter = strtoupper(trim($_GET['letter'] ?? ''));

// Recherche
if ($search !== '') {
    $utilisateurs = array_filter($utilisateurs, function ($utilisateur) use ($search) {
        $search = mb_strtolower($search);

        return mb_strpos(mb_strtolower($utilisateur['nom']), $search) !== false
            || mb_strpos(mb_strtolower($utilisateur['prenom']), $search) !== false
            || mb_strpos(mb_strtolower($utilisateur['email']), $search) !== false;
    });
}

// Filtre alphabétique
if ($letter !== '' && preg_match('/^[A-Z]$/', $letter)) {
    $utilisateurs = array_filter($utilisateurs, function ($utilisateur) use ($letter) {
        $premiere_lettre = mb_strtoupper(mb_substr($utilisateur['nom'], 0, 1));
        return $premiere_lettre === $letter;
    });
}

// Réindexation après filtrage
$utilisateurs = array_values($utilisateurs);

// Pagination utilisateurs
$utilisateurs_par_page = 10;
$page_utilisateurs = isset($_GET['user_page']) ? (int) $_GET['user_page'] : 1;

if ($page_utilisateurs < 1) {
    $page_utilisateurs = 1;
}

$total_utilisateurs = count($utilisateurs);
$total_pages_utilisateurs = (int) ceil($total_utilisateurs / $utilisateurs_par_page);
$offset_utilisateurs = ($page_utilisateurs - 1) * $utilisateurs_par_page;

$utilisateurs = array_slice($utilisateurs, $offset_utilisateurs, $utilisateurs_par_page);


$categories_selectionnees = [];

if ($article_a_modifier) {
    $categories_selectionnees = getCategoryIdsByArticle($pdo, $article_a_modifier['id_article']);
}


// =========================
// AFFICHAGE DU TABLEAU DE BORD ADMINISTRATEUR
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/admin/dashboard.php';
require_once BASE_PATH . '/app/views/pages/footer.php';