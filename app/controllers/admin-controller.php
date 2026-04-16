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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $messageId = (int) $_POST['delete'];
    deleteMessage($pdo, $messageId);

    header('Location: index.php?page=admin&section=messages');
    exit;
}

$messages = getAllMessages($pdo);

$messageDate = trim($_GET['message_date'] ?? '');

if ($messageDate !== '') {
    $messages = array_filter($messages, function ($message) use ($messageDate) {
        return strpos($message['date_envoi'], $messageDate) === 0;
    });
}

$messages = array_values($messages);

$messagesPerPage = 10;
$currentMessagePage = isset($_GET['message_page']) ? (int) $_GET['message_page'] : 1;

if ($currentMessagePage < 1) {
    $currentMessagePage = 1;
}

$totalMessages = count($messages);
$totalMessagePages = ($totalMessages > 0) ? (int) ceil($totalMessages / $messagesPerPage) : 1;

if ($currentMessagePage > $totalMessagePages) {
    $currentMessagePage = $totalMessagePages;
}

$messageOffset = ($currentMessagePage - 1) * $messagesPerPage;
$messages = array_slice($messages, $messageOffset, $messagesPerPage);

$messagePagination = [
    'currentPage' => $currentMessagePage,
    'totalPages' => $totalMessagePages
];



// =====================================================
// ===================== ARTICLES =======================
// =====================================================

function addImageToArticle($pdo, $articleId, &$errorMessage = '')
{
    if (
        !isset($_FILES['image']) ||
        empty($_FILES['image']['name']) ||
        $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return true;
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = 'Erreur lors de l’envoi du fichier.';
        return false;
    }

    $maxSize = 2 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        $errorMessage = 'L’image est trop volumineuse. Taille maximum : 2 Mo.';
        return false;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions, true)) {
        $errorMessage = 'Format d’image non autorisé.';
        return false;
    }

    $uploadDirectory = BASE_PATH . '/public/uploads/';

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            $errorMessage = 'Impossible de créer le dossier uploads.';
            return false;
        }
    }

    if (!is_writable($uploadDirectory)) {
        $errorMessage = 'Le dossier uploads n’est pas accessible en écriture.';
        return false;
    }

    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES['image']['name']));
    $fileName = uniqid() . '_' . $safeName;
    $filePath = $uploadDirectory . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        $errorMessage = 'Impossible d’enregistrer l’image dans le dossier uploads.';
        return false;
    }

    $mediaId = createMedia($pdo, $fileName, 'image');

    if (!$mediaId) {
        $errorMessage = 'L’image a été envoyée mais pas enregistrée dans la base de données.';
        return false;
    }

    $medias = getMediaByArticle($pdo, $articleId);
    $order = count($medias) + 1;
    $isMainImage = empty($medias) ? 1 : 0;

    if (!linkMediaToArticle($pdo, $articleId, $mediaId, $order, $isMainImage)) {
        $errorMessage = 'L’image a été envoyée mais pas liée à l’article.';
        return false;
    }

    return true;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    $articleId = (int) $_POST['delete_article'];

    deleteArticleCategories($pdo, $articleId);
    deleteArticle($pdo, $articleId);

    header('Location: index.php?page=admin&section=articles');
    exit;
}


if (isset($_GET['edit_article'])) {
    $articleId = (int) $_GET['edit_article'];
    $articleToEdit = getArticleById($pdo, $articleId);
    $section = 'articles';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'])) {
    $title = trim($_POST['titre'] ?? '');
    $content = trim($_POST['contenu'] ?? '');
    $userId = $_SESSION['user']['id_utilisateur'];
    $selectedCategories = $_POST['categories'] ?? [];

    if (mb_strlen($title) < 3 || mb_strlen($title) > 255) {
        $errorMessage = 'Le titre doit contenir entre 3 et 255 caractères.';
        $section = 'articles';
    } elseif (mb_strlen($content) < 10) {
        $errorMessage = 'Le contenu doit contenir au moins 10 caractères.';
        $section = 'articles';
    } else {
        if (isset($_POST['id_article']) && !empty($_POST['id_article'])) {
            $articleId = (int) $_POST['id_article'];

            if (!updateArticle($pdo, $articleId, $title, $content)) {
                $errorMessage = 'Erreur lors de la modification de l’article.';
                $section = 'articles';
            } else {
                deleteArticleCategories($pdo, $articleId);

                foreach ($selectedCategories as $categoryId) {
                    addArticleCategory($pdo, $articleId, $categoryId);
                }

                if (addImageToArticle($pdo, $articleId, $errorMessage)) {
                    header('Location: index.php?page=admin&section=articles');
                    exit;
                }

                $articleToEdit = getArticleById($pdo, $articleId);
                $section = 'articles';
            }
        } else {
            $articleId = createArticle($pdo, $title, $content, $userId);

            if (!$articleId) {
                $errorMessage = 'Erreur lors de la création de l’article.';
                $section = 'articles';
            } else {
                foreach ($selectedCategories as $categoryId) {
                    addArticleCategory($pdo, $articleId, $categoryId);
                }

                if (addImageToArticle($pdo, $articleId, $errorMessage)) {
                    header('Location: index.php?page=admin&section=articles');
                    exit;
                }

                $section = 'articles';
            }
        }
    }
}


$articles = getAllArticles($pdo);

$articleSearch = trim($_GET['article_search'] ?? '');
$articleDate = trim($_GET['article_date'] ?? '');

if ($articleSearch !== '') {
    $articles = array_filter($articles, function ($article) use ($articleSearch) {
        return mb_stripos($article['titre'], $articleSearch) !== false;
    });
}

if ($articleDate !== '') {
    $articles = array_filter($articles, function ($article) use ($articleDate) {
        return strpos($article['date_publication'], $articleDate) === 0;
    });
}

$articles = array_values($articles);

$articlesPerPage = 2;
$currentArticlePage = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($currentArticlePage < 1) {
    $currentArticlePage = 1;
}

$totalArticles = count($articles);
$totalArticlePages = ($totalArticles > 0) ? (int) ceil($totalArticles / $articlesPerPage) : 1;

if ($currentArticlePage > $totalArticlePages) {
    $currentArticlePage = $totalArticlePages;
}

$articleOffset = ($currentArticlePage - 1) * $articlesPerPage;
$articles = array_slice($articles, $articleOffset, $articlesPerPage);

$categories = getAllCategories($pdo);

// =====================================================
// ===================== UTILISATEURS ===================
// =====================================================

$users = getAllUsers($pdo);

$userSearch = trim($_GET['user_search'] ?? '');
$letter = strtoupper(trim($_GET['letter'] ?? ''));

if ($userSearch !== '') {
    $users = array_filter($users, function ($user) use ($userSearch) {
        $userSearch = mb_strtolower($userSearch);

        return mb_strpos(mb_strtolower($user['nom']), $userSearch) !== false
            || mb_strpos(mb_strtolower($user['prenom']), $userSearch) !== false
            || mb_strpos(mb_strtolower($user['email']), $userSearch) !== false;
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
$totalUserPages = ($totalUsers > 0) ? (int) ceil($totalUsers / $usersPerPage) : 1;

if ($currentUserPage > $totalUserPages) {
    $currentUserPage = $totalUserPages;
}

$userOffset = ($currentUserPage - 1) * $usersPerPage;
$users = array_slice($users, $userOffset, $usersPerPage);

// pagination simple (variables utilisées dans la vue)
$userPagination = [
    'currentPage' => $currentUserPage,
    'totalPages' => $totalUserPages
];

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