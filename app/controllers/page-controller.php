<?php

// =========================
// LISTE DES PAGES AUTORISÉES
// =========================
$pages = [
    'oiseau' => 'bird',
    'nid' => 'nest',
    'galerie' => 'gallery',
    'inaturalist' => 'inaturalist',
    'mentions-legales' => 'legal-notice',
    'politique-confidentialite' => 'privacy-policy',
    'cgu' => 'terms'
];

// =========================
// SÉCURITÉ
// =========================
if (!isset($page)) {
    $page = 'accueil';
}

require_once BASE_PATH . '/app/views/layouts/header.php';

// =========================
// AFFICHAGE DES PAGES
// =========================
if (array_key_exists($page, $pages)) {
    $view = $pages[$page];
    require_once BASE_PATH . '/app/views/pages/' . $view . '.php';
} else {
    require_once BASE_PATH . '/app/views/pages/404.php';
}

require_once BASE_PATH . '/app/views/layouts/footer.php';