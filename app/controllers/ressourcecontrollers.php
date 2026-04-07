<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/utilisateur/ressources.php';
require_once __DIR__ . '/../views/pages/footer.php';