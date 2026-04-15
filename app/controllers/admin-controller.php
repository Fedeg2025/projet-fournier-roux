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
// CHARGEMENT DES MODÈLES
// =========================
require_once BASE_PATH . '/app/models/message.php';
require_once BASE_PATH . '/app/models/article.php';
require_once BASE_PATH . '/app/models/category.php';
require_once BASE_PATH . '/app/models/user.php';
require_once BASE_PATH . '/app/models/media.php';


// =========================
// VARIABLES GLOBALES
// =========================
$articleToEdit = null;
$errorMessage = '';
$successMessage = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$section = $_GET['section'] ?? 'messages';

$allowedSections = ['messages', 'articles', 'utilisateurs'];

if (!in_array($section, $allowedSections, true)) {
    $section = 'messages';
}

$confirmDelete = isset($_GET['confirm_delete']) ? (int) $_GET['confirm_delete'] : 0;
$confirmDeleteMessage = isset($_GET['confirm_delete_message']) ? (int) $_GET['confirm_delete_message'] : 0;


// =====================================================
// ===================== MESSAGES =======================
// =====================================================

// SUPPRESSION D’UN MESSAGE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $messageId = (int) $_POST['delete'];
    deleteMessage($pdo, $messageId);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=messages');
    exit;
}

// RÉCUPÉRATION DES MESSAGES
$messages = getAllMessages($pdo);


// =====================================================
// ===================== ARTICLES =======================
// =====================================================

// FONCTION IMAGE (liée aux articles)
function addImageToArticle($pdo, $articleId)
{
    if (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== 0 ||
        empty($_FILES['image']['tmp_name'])
    ) {
        return;
    }

    $maxSize = 2 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        return;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mimeType = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($mimeType, $allowedTypes, true)) {
        return;
    }

    $uploadDirectory = BASE_PATH . '/public/uploads/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = uniqid() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES['image']['name']));
    $filePath = $uploadDirectory . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        createMedia($pdo, $fileName, 'image');
        $mediaId = $pdo->lastInsertId();
        linkMediaToArticle($pdo, $articleId, $mediaId);
    }
}

// SUPPRESSION D’UN ARTICLE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    $articleId = (int) $_POST['delete_article'];

    deleteArticleCategories($pdo, $articleId);
    deleteArticleMedia($pdo, $articleId);
    deleteArticle($pdo, $articleId);

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: index.php?page=admin&section=articles');
    exit;
}

// CHARGEMENT D’UN ARTICLE À MODIFIER
if (isset($_GET['edit_article'])) {
    $articleId = (int) $_GET['edit_article'];
    $articleToEdit = getArticleById($pdo, $articleId);
    $section = 'articles';
}

// CRÉATION OU MODIFICATION D’UN ARTICLE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = 'Requête invalide (CSRF).';
    } else {
        $title = trim($_POST['titre'] ?? '');
        $content = trim($_POST['contenu'] ?? '');
        $userId = $_SESSION['user']['id_utilisateur'];
        $selectedCategories = $_POST['categories'] ?? [];

        if (mb_strlen($title) < 3 || mb_strlen($title) > 255) {
            $errorMessage = 'Le titre doit contenir entre 3 et 255 caractères.';
        } elseif (mb_strlen($content) < 10) {
            $errorMessage = 'Le contenu doit contenir au moins 10 caractères.';
        } else {

            // MODIFICATION
            if (isset($_POST['id_article']) && !empty($_POST['id_article'])) {
                $articleId = (int) $_POST['id_article'];

                updateArticle($pdo, $articleId, $title, $content);
                deleteArticleCategories($pdo, $articleId);

                foreach ($selectedCategories as $categoryId) {
                    addArticleCategory($pdo, $articleId, $categoryId);
                }

                addImageToArticle($pdo, $articleId);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: index.php?page=admin&section=articles');
                exit;
            }

            // CRÉATION
            createArticle($pdo, $title, $content, $userId);

            $articleId = $pdo->lastInsertId();

            foreach ($selectedCategories as $categoryId) {
                addArticleCategory($pdo, $articleId, $categoryId);
            }

            addImageToArticle($pdo, $articleId);

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: index.php?page=admin&section=articles');
            exit;
        }
    }
}

// RÉCUPÉRATION DES ARTICLES
$articles = getAllArticles($pdo);

$articlesPerPage = 2;
$currentArticlePage = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($currentArticlePage < 1) {
    $currentArticlePage = 1;
}

$totalArticles = count($articles);
$totalArticlePages = (int) ceil($totalArticles / $articlesPerPage);

if ($totalArticlePages > 0 && $currentArticlePage > $totalArticlePages) {
    $currentArticlePage = $totalArticlePages;
}

$articleOffset = ($currentArticlePage - 1) * $articlesPerPage;
$articles = array_slice($articles, $articleOffset, $articlesPerPage);

foreach ($articles as &$article) {
    $article['medias'] = getMediaByArticle($pdo, $article['id_article']);
}
unset($article);

$categories = getAllCategories($pdo);


// =====================================================
// ===================== UTILISATEURS ===================
// =====================================================

$users = getAllUsers($pdo);

$search = trim($_GET['search'] ?? '');
$letter = strtoupper(trim($_GET['letter'] ?? ''));

if ($search !== '') {
    $users = array_filter($users, function ($user) use ($search) {
        $search = mb_strtolower($search);

        return mb_strpos(mb_strtolower($user['nom']), $search) !== false
            || mb_strpos(mb_strtolower($user['prenom']), $search) !== false
            || mb_strpos(mb_strtolower($user['email']), $search) !== false;
    });
}

if ($letter !== '' && preg_match('/^[A-Z]$/', $letter)) {
    $users = array_filter($users, function ($user) use ($letter) {
        $firstLetter = mb_strtoupper(mb_substr($user['nom'], 0, 1));
        return $firstLetter === $letter;
    });
}

$users = array_values($users);

$usersPerPage = 10;
$currentUserPage = isset($_GET['user_page']) ? (int) $_GET['user_page'] : 1;

if ($currentUserPage < 1) {
    $currentUserPage = 1;
}

$totalUsers = count($users);
$totalUserPages = (int) ceil($totalUsers / $usersPerPage);

if ($totalUserPages > 0 && $currentUserPage > $totalUserPages) {
    $currentUserPage = $totalUserPages;
}

$userOffset = ($currentUserPage - 1) * $usersPerPage;
$users = array_slice($users, $userOffset, $usersPerPage);


// =========================
// CATÉGORIES ARTICLE EN COURS
// =========================
$selectedCategories = [];

if ($articleToEdit) {
    $selectedCategories = getCategoryIdsByArticle($pdo, $articleToEdit['id_article']);
}


// =========================
// AFFICHAGE FINAL
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/admin/dashboard.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';