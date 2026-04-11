<?php

$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    // Pages publiques
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

    // Authentification
    case 'login':
    case 'register':
    case 'logout':
        require_once BASE_PATH . '/app/controllers/authentificationcontrollers.php';
        break;

    // Utilisateur
    case 'profil':
        require_once BASE_PATH . '/app/controllers/usercontrollers.php';
        break;

    // Contact
    case 'contact':
        require_once BASE_PATH . '/app/controllers/contactcontrollers.php';
        break;

    // Articles
    case 'articles':
        require_once BASE_PATH . '/app/controllers/articlecontrollers.php';
        break;

    case 'article':
        require_once BASE_PATH . '/app/controllers/article-single-controller.php';
        break;

    // Ressources
    case 'ressources':
        require_once BASE_PATH . '/app/controllers/ressourcecontrollers.php';
        break;

    // Administration
    case 'admin':
        require_once BASE_PATH . '/app/controllers/admincontrollers.php';
        break;

    // Page introuvable
    default:
        require_once BASE_PATH . '/app/views/pages/404.php';
        break;
}