<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {

    case 'accueil':
        require_once __DIR__ . '/../app/controllers/homecontrollers.php';
        break;

    case 'login':
    case 'register':
    case 'logout':
    case 'mot-de-passe-oublie':
    case 'nouveau-mot-de-passe':
        require_once __DIR__ . '/../app/controllers/authentificationcontrollers.php';
        break;

    case 'oiseau':
    case 'nid':
    case 'galerie':
    case 'inaturalist':
    case 'mentions-legales':
    case 'politique-confidentialite':
    case 'cgu':
        require_once __DIR__ . '/../app/controllers/pagecontrollers.php';
        break;

    case 'profil':
        require_once __DIR__ . '/../app/controllers/usercontrollers.php';
        break;

    case 'contact':
        require_once __DIR__ . '/../app/controllers/contactcontrollers.php';
        break;

    case 'articles':
        require_once __DIR__ . '/../app/controllers/articlecontrollers.php';
        break;

    case 'article':
        require_once __DIR__ . '/../app/controllers/article-single-controller.php';
        break;

    case 'ressources':
        require_once __DIR__ . '/../app/controllers/ressourcecontrollers.php';
        break;

    case 'admin':
        require_once __DIR__ . '/../app/controllers/admincontrollers.php';
        break;

    default:
        require_once __DIR__ . '/../app/views/pages/404.php';
        break;
}