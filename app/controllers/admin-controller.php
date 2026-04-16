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

// SUPPRESSION D’UN MESSAGE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $messageId = (int) $_POST['delete'];
    deleteMessage($pdo, $messageId);

    header('Location: index.php?page=admin&section=messages');
    exit;
}

// RÉCUPÉRATION DES MESSAGES
$messages = getAllMessages($pdo);


// =====================================================
// ===================== ARTICLES =======================
// =====================================================

// =========================
// FONCTION IMAGE
// Cette fonction ajoute ou remplace
// l’image d’un article
// Retour :
// - true si image enregistrée
// - false si erreur
// =========================
function addImageToArticle($pdo, $articleId, &$errorMessage = '')
{
    if (
        !isset($_FILES['image']) ||
        empty($_FILES['image']['name']) ||
        $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
    ) {
        // Pas d’image envoyée : ce n’est pas une erreur
        return true;
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = 'Erreur lors de l’envoi du fichier.';
        error_log('Upload error code : ' . $_FILES['image']['error']);
        return false;
    }

    if (empty($_FILES['image']['tmp_name'])) {
        $errorMessage = 'Fichier temporaire introuvable.';
        error_log('tmp_name vide pour image.');
        return false;
    }

    $maxSize = 2 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        $errorMessage = 'L’image est trop volumineuse. Taille maximum : 2 Mo.';
        return false;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mimeType = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($mimeType, $allowedTypes, true)) {
        $errorMessage = 'Format d’image non autorisé.';
        error_log('Type MIME refusé : ' . $mimeType);
        return false;
    }

    $uploadDirectory = BASE_PATH . '/public/uploads/';

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            $errorMessage = 'Impossible de créer le dossier uploads.';
            error_log('Impossible de créer le dossier : ' . $uploadDirectory);
            return false;
        }
    }

    if (!is_writable($uploadDirectory)) {
        $errorMessage = 'Le dossier uploads n’est pas accessible en écriture.';
        error_log('Dossier non inscriptible : ' . $uploadDirectory);
        return false;
    }

    $currentArticle = getArticleById($pdo, $articleId);

    if (!empty($currentArticle['nom_fichier_image'])) {
        $oldImagePath = $uploadDirectory . $currentArticle['nom_fichier_image'];

        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES['image']['name']));
    $fileName = uniqid() . '_' . $safeName;
    $filePath = $uploadDirectory . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        $errorMessage = 'Impossible d’enregistrer l’image dans le dossier uploads.';
        error_log('move_uploaded_file a échoué vers : ' . $filePath);
        return false;
    }

    if (!updateArticleImage($pdo, $articleId, $fileName)) {
        $errorMessage = 'L’image a été envoyée mais pas enregistrée dans la base de données.';
        error_log('Échec updateArticleImage pour article : ' . $articleId);
        return false;
    }

    return true;
}


// SUPPRESSION D’UN ARTICLE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    $articleId = (int) $_POST['delete_article'];

    $article = getArticleById($pdo, $articleId);

    if (!empty($article['nom_fichier_image'])) {
        $imagePath = BASE_PATH . '/public/uploads/' . $article['nom_fichier_image'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    deleteArticleCategories($pdo, $articleId);
    deleteArticle($pdo, $articleId);

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

        // =========================
        // MODIFICATION
        // =========================
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
            // =========================
            // CRÉATION
            // =========================
            if (!createArticle($pdo, $title, $content, $userId)) {
                $errorMessage = 'Erreur lors de la création de l’article.';
                $section = 'articles';
            } else {
                $articleId = $pdo->lastInsertId();

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


// RÉCUPÉRATION DES ARTICLES
$articles = getAllArticles($pdo);

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
$totalUserPages = ($totalUsers > 0) ? (int) ceil($totalUsers / $usersPerPage) : 1;

if ($currentUserPage > $totalUserPages) {
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