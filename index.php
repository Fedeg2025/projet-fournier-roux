<?php

// =========================
// POINT D’ENTRÉE PRINCIPAL
// Ce fichier démarre la session,
// initialise les éléments globaux
// et lance le routeur principal
// =========================


// =========================
// DÉMARRAGE DE LA SESSION
// =========================
session_start();


// =========================
// DÉFINITION DU CHEMIN RACINE
// =========================
define('BASE_PATH', __DIR__);


// =========================
// GÉNÉRATION DU TOKEN CSRF
// Ce token est généré une seule
// fois par session utilisateur
// =========================
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// =========================
// CONNEXION À LA BASE DE DONNÉES
// Ce fichier crée l’instance PDO
// =========================
require_once BASE_PATH . '/config/database.php';


// =========================
// CHARGEMENT DU ROUTEUR PRINCIPAL
// =========================
require_once BASE_PATH . '/routes/router.php';