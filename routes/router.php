<?php

// =========================
// PAGE DEMANDÉE
// Si aucune page n'est indiquée, on affiche l'accueil
// =========================
$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    // =========================
    // PAGES PUBLIQUES
    // =========================
    case 'accueil':
        require_once BASE_PATH . '/app/controllers/homecontrollers.php';
        break;

    case 'oiseau':
    case 'nid':
    case 'galerie':
    case 'inaturalist':
    case 'mentions-legales':
    case 'politique-confidentialite':
    case 'cgu':
        require_once BASE_PATH . '/app/controllers/pagecontrollers.php';
        break;

    // =========================
    // AUTHENTIFICATION
    // Le routeur décide quelle fonction appeler
    // =========================
    case 'login':
        require_once BASE_PATH . '/app/controllers/authentificationcontrollers.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            traiterLogin();
        } else {
            afficherLogin();
        }
        break;

    case 'register':
        require_once BASE_PATH . '/app/controllers/authentificationcontrollers.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            traiterRegister();
        } else {
            afficherRegister();
        }
        break;

    case 'logout':
        require_once BASE_PATH . '/app/controllers/authentificationcontrollers.php';
        traiterLogout();
        break;

    case 'mot-de-passe-oublie':
    case 'nouveau-mot-de-passe':
        require_once BASE_PATH . '/app/controllers/authentificationcontrollers.php';
        redirigerMotDePasseOublie();
        break;

    // =========================
    // UTILISATEUR
    // =========================
    case 'profil':
        require_once BASE_PATH . '/app/controllers/usercontrollers.php';
        break;

    // =========================
    // CONTACT
    // Le routeur appelle la bonne fonction
    // selon la méthode HTTP
    // =========================
    case 'contact':
        require_once BASE_PATH . '/app/controllers/contactcontrollers.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            traiterContact();
        } else {
            afficherContact();
        }
        break;

    // =========================
    // ARTICLES
    // =========================
    case 'articles':
        require_once BASE_PATH . '/app/controllers/articlecontrollers.php';
        break;

    case 'article':
        require_once BASE_PATH . '/app/controllers/article-single-controller.php';
        break;

    // =========================
    // RESSOURCES
    // =========================
    case 'ressources':
        require_once BASE_PATH . '/app/controllers/ressourcecontrollers.php';
        break;

    // =========================
    // ADMINISTRATION
    // =========================
    case 'admin':
        require_once BASE_PATH . '/app/controllers/admincontrollers.php';
        break;

    // =========================
    // PAGE INTROUVABLE
    // =========================
    default:
        http_response_code(404);
        require_once BASE_PATH . '/app/views/pages/404.php';
        break;
}