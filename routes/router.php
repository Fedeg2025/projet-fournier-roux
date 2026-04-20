<?php

// =========================
// PAGE DEMANDÉE
// =========================
$page = isset($_GET['page']) ? trim($_GET['page']) : 'accueil';

switch ($page) {

    // =========================
    // PAGES PUBLIQUES
    // =========================
    case 'accueil':
        require_once BASE_PATH . '/app/controllers/home-controller.php';
        break;

    case 'oiseau':
    case 'nid':
    case 'galerie':
    case 'inaturalist':
    case 'mentions-legales':
    case 'politique-confidentialite':
    case 'cgu':
        require_once BASE_PATH . '/app/controllers/page-controller.php';
        break;

    case 'error':
        require_once BASE_PATH . '/app/views/error.php';
        break;

    // =========================
    // AUTHENTIFICATION
    // =========================
    case 'login':
        require_once BASE_PATH . '/app/controllers/auth-controller.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            processLogin();
        } else {
            showLogin();
        }
        break;

    case 'register':
        require_once BASE_PATH . '/app/controllers/auth-controller.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            processRegister();
        } else {
            showRegister();
        }
        break;

    case 'logout':
        require_once BASE_PATH . '/app/controllers/auth-controller.php';
        processLogout();
        break;

    case 'mot-de-passe-oublie':
    case 'nouveau-mot-de-passe':
        require_once BASE_PATH . '/app/controllers/auth-controller.php';
        redirectForgotPassword();
        break;

    // =========================
    // UTILISATEUR
    // =========================
    case 'profil':
        require_once BASE_PATH . '/app/controllers/user-controller.php';
        break;

    // =========================
    // CONTACT
    // =========================
    case 'contact':
        require_once BASE_PATH . '/app/controllers/contact-controller.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            processContact();
        } else {
            showContact();
        }
        break;

    // =========================
    // ARTICLES
    // =========================
    case 'articles':
        require_once BASE_PATH . '/app/controllers/article-controller.php';
        break;

    case 'article':
        require_once BASE_PATH . '/app/controllers/article-single-controller.php';
        break;

    // =========================
    // RESSOURCES
    // =========================
    case 'ressources':
        require_once BASE_PATH . '/app/controllers/resource-controller.php';
        break;

    // =========================
    // ADMINISTRATION
    // =========================
    case 'admin':
        require_once BASE_PATH . '/app/controllers/admin-controller.php';
        break;

    // =========================
    // PAGE INTROUVABLE
    // =========================
    default:
        http_response_code(404);
        require_once BASE_PATH . '/app/views/pages/404.php';
        break;
}