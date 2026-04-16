<?php

// =========================
// SÉCURITÉ ADMIN
// =========================

/**
 * Vérifie que l'utilisateur connecté est administrateur.
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
$errorMessage = '';
$successMessage = '';
$articleToEdit = null;

$section = $_GET['section'] ?? 'messages';
$allowedSections = ['messages', 'articles', 'utilisateurs', 'medias'];

if (!in_array($section, $allowedSections, true)) {
    $section = 'messages';
}

$confirmDelete = isset($_GET['confirm_delete']) ? (int) $_GET['confirm_delete'] : 0;
$confirmDeleteMessage = isset($_GET['confirm_delete_message']) ? (int) $_GET['confirm_delete_message'] : 0;


// =========================
// VARIABLES PAR DÉFAUT
// =========================
$messages = [];
$messageDate = '';
$messagePagination = [
    'currentPage' => 1,
    'totalPages' => 1
];

$users = [];
$userSearch = '';
$userPagination = [
    'currentPage' => 1,
    'totalPages' => 1
];

$articles = [];
$articleSearch = '';
$articleDate = '';
$articlePagination = [
    'currentPage' => 1,
    'totalPages' => 1
];

$categories = [];
$selectedCategories = [];

$medias = [];


// =========================
// CHARGEMENT DU SOUS-CONTRÔLEUR
// =========================
switch ($section) {
    case 'messages':
        require_once BASE_PATH . '/app/controllers/messages-admin-controller.php';
        break;

    case 'utilisateurs':
        require_once BASE_PATH . '/app/controllers/users-admin-controller.php';
        break;

    case 'articles':
        require_once BASE_PATH . '/app/controllers/articles-admin-controller.php';
        break;

    case 'medias':
        require_once BASE_PATH . '/app/controllers/medias-admin-controller.php';
        break;

    default:
        require_once BASE_PATH . '/app/controllers/messages-admin-controller.php';
        break;
}


// =========================
// AFFICHAGE FINAL
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/admin/dashboard.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';