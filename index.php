<?php

// Démarrage de la session
session_start();

// Définition du chemin racine du projet
define('BASE_PATH', __DIR__);

// Génération du token CSRF (une seule fois par session)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Connexion à la base de données
require_once BASE_PATH . '/config/database.php';

// Lancement du routeur
require_once BASE_PATH . '/routes/router.php';