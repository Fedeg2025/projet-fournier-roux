<?php

// =========================
// PAGE COURANTE
// =========================
$page = $_GET['page'] ?? 'accueil';

// =========================
// PAGES AUTORISÉES
// =========================
$pages = [
    'oiseau',
    'nid',
    'galerie',
    'inaturalist',
    'mentions-legales',
    'politique-confidentialite',
    'cgu'
];

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';

if (in_array($page, $pages, true)) {
    require_once BASE_PATH . '/app/views/pages/' . $page . '.php';
} else {
    require_once BASE_PATH . '/app/views/pages/404.php';
}

require_once BASE_PATH . '/app/views/pages/footer.php';