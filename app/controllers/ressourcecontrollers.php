<?php

// =========================
// SÉCURITÉ
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/ressources.php';
require_once BASE_PATH . '/app/views/pages/footer.php';