<?php

// =====================================================
// ================= FONCTIONS IMAGES ===================
// =====================================================

/**
 * Ajoute une ou plusieurs images à un article.
 */
function addImagesToArticle(PDO $pdo, int $articleId, string &$errorMessage = ''): bool
{
    if (
        !isset($_FILES['images']) ||
        !isset($_FILES['images']['name']) ||
        empty($_FILES['images']['name'][0])
    ) {
        return true;
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

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $maxSize = 2 * 1024 * 1024;

    $existingMedias = getMediaByArticle($pdo, $articleId);
    $displayOrder = count($existingMedias) + 1;
    $isMainImage = empty($existingMedias) ? 1 : 0;

    foreach ($_FILES['images']['name'] as $index => $originalName) {
        if ($_FILES['images']['error'][$index] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) {
            $errorMessage = 'Erreur lors de l’envoi d’une image.';
            return false;
        }

        if ($_FILES['images']['size'][$index] > $maxSize) {
            $errorMessage = 'Une image est trop volumineuse. Taille maximum : 2 Mo.';
            return false;
        }

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            $errorMessage = 'Un format d’image n’est pas autorisé.';
            return false;
        }

        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($originalName));
        $fileName = uniqid('article_', true) . '_' . $safeName;
        $filePath = $uploadDirectory . $fileName;

        if (!move_uploaded_file($_FILES['images']['tmp_name'][$index], $filePath)) {
            $errorMessage = 'Impossible d’enregistrer une image dans le dossier uploads.';
            return false;
        }

        $mediaId = createMedia($pdo, $fileName, 'image');

        if (!$mediaId) {
            $errorMessage = 'Une image a été envoyée mais pas enregistrée dans la base de données.';
            return false;
        }

        if (!linkMediaToArticle($pdo, $articleId, $mediaId, $displayOrder, $isMainImage)) {
            $errorMessage = 'Une image a été envoyée mais pas liée à l’article.';
            return false;
        }

        $displayOrder++;
        $isMainImage = 0;
    }

    return true;
}


// =====================================================
// ================= SUPPRESSION ARTICLE ================
// =====================================================

/**
 * Supprime un article et ses catégories associées.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    $articleId = (int) $_POST['delete_article'];

    deleteArticleCategories($pdo, $articleId);
    deleteArticle($pdo, $articleId);

    header('Location: index.php?page=admin&section=articles');
    exit;
}


// =====================================================
// ================= ÉDITION ARTICLE ====================
// =====================================================

/**
 * Charge l'article à modifier.
 */
if (isset($_GET['edit_article'])) {
    $articleId = (int) $_GET['edit_article'];
    $articleToEdit = getArticleById($pdo, $articleId);
}


// =====================================================
// ================= ENREGISTREMENT ARTICLE =============
// =====================================================

/**
 * Crée ou modifie un article.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'])) {
    $title = trim($_POST['titre'] ?? '');
    $content = trim($_POST['contenu'] ?? '');
    $userId = (int) $_SESSION['user']['id_utilisateur'];
    $selectedCategories = $_POST['categories'] ?? [];

    if (mb_strlen($title) < 3 || mb_strlen($title) > 255) {
        $errorMessage = 'Le titre doit contenir entre 3 et 255 caractères.';
    } elseif (mb_strlen($content) < 10) {
        $errorMessage = 'Le contenu doit contenir au moins 10 caractères.';
    } else {
        if (isset($_POST['id_article']) && !empty($_POST['id_article'])) {
            $articleId = (int) $_POST['id_article'];

            if (!updateArticle($pdo, $articleId, $title, $content)) {
                $errorMessage = 'Erreur lors de la modification de l’article.';
            } else {
                deleteArticleCategories($pdo, $articleId);

                foreach ($selectedCategories as $categoryId) {
                    addArticleCategory($pdo, $articleId, (int) $categoryId);
                }

                if (addImagesToArticle($pdo, $articleId, $errorMessage)) {
                    header('Location: index.php?page=admin&section=articles');
                    exit;
                }

                $articleToEdit = getArticleById($pdo, $articleId);
            }
        } else {
            $articleId = createArticle($pdo, $title, $content, $userId);

            if (!$articleId) {
                $errorMessage = 'Erreur lors de la création de l’article.';
            } else {
                foreach ($selectedCategories as $categoryId) {
                    addArticleCategory($pdo, $articleId, (int) $categoryId);
                }

                if (addImagesToArticle($pdo, $articleId, $errorMessage)) {
                    header('Location: index.php?page=admin&section=articles');
                    exit;
                }
            }
        }
    }
}


// =====================================================
// ================= LISTE DES ARTICLES =================
// =====================================================

/**
 * Récupère tous les articles pour l'administration.
 */
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


// =====================================================
// ================= PAGINATION ARTICLES ================
// =====================================================

/**
 * Prépare la pagination des articles.
 */
$articlesPerPage = 3;
$currentArticlePage = isset($_GET['p']) ? (int) $_GET['p'] : 1;

if ($currentArticlePage < 1) {
    $currentArticlePage = 1;
}

$totalArticles = count($articles);
$totalArticlePages = $totalArticles > 0 ? (int) ceil($totalArticles / $articlesPerPage) : 1;

if ($currentArticlePage > $totalArticlePages) {
    $currentArticlePage = $totalArticlePages;
}

$articleOffset = ($currentArticlePage - 1) * $articlesPerPage;
$articles = array_slice($articles, $articleOffset, $articlesPerPage);

$articlePagination = [
    'currentPage' => $currentArticlePage,
    'totalPages' => $totalArticlePages
];


// =====================================================
// ================= CATÉGORIES =========================
// =====================================================

/**
 * Récupère les catégories disponibles.
 */
$categories = getAllCategories($pdo);

if ($articleToEdit) {
    $selectedCategories = getCategoryIdsByArticle($pdo, $articleToEdit['id_article']);
}