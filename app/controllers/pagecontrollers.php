<?php

// =========================
// LISTE DES PAGES AUTORISÉES
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
// AFFICHAGE DES PAGES SIMPLES
// Ce contrôleur affiche une page statique selon la variable $page
// =========================

// Sécurité : on vérifie que la variable $page existe
if (!isset($page)) {
    $page = 'accueil';
}

require_once BASE_PATH . '/app/views/pages/header.php';

// Vérification que la page est autorisée
if (in_array($page, $pages, true)) {
    require_once BASE_PATH . '/app/views/pages/' . $page . '.php';
} else {
    require_once BASE_PATH . '/app/views/pages/404.php';
}

require_once BASE_PATH . '/app/views/pages/footer.php';