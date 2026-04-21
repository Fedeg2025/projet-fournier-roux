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
if (session_status() === PHP_SESSION_NONE) {
    session_name('fournier_roux');
    session_start();
}


// =========================
// DÉFINITION DU CHEMIN RACINE
// =========================
define('BASE_PATH', __DIR__);


// =========================
// CONNEXION À LA BASE DE DONNÉES
// Ce fichier crée l’instance PDO
// =========================
require_once BASE_PATH . '/config/database.php';


// =========================
// CHARGEMENT DU ROUTEUR PRINCIPAL
// =========================
require_once BASE_PATH . '/routes/router.php';