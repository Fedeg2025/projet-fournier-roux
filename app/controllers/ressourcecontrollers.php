<?php

// =========================
// VÉRIFICATION DE L'AUTHENTIFICATION
// Cette page est accessible uniquement
// aux utilisateurs connectés
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// =========================
// AFFICHAGE DE LA PAGE RESSOURCES
// Ce contrôleur affiche les ressources pédagogiques
// réservées aux utilisateurs connectés
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/ressources.php';
require_once BASE_PATH . '/app/views/pages/footer.php';