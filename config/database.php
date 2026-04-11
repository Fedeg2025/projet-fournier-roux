<?php

// =========================
// CHARGEMENT DE LA CONFIGURATION
// Ce fichier récupère les variables
// nécessaires à la connexion à la base de données
// =========================
$config = require BASE_PATH . '/config/env.php';

$hote = $config['DB_HOST'];
$nom_base = $config['DB_NAME'];
$nom_utilisateur = $config['DB_USER'];
$mot_de_passe = $config['DB_PASS'];


// =========================
// CONNEXION À LA BASE DE DONNÉES
// Une instance PDO est créée avec gestion des erreurs
// et récupération automatique en tableau associatif
// =========================
try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$nom_base;charset=utf8mb4",
        $nom_utilisateur,
        $mot_de_passe,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );


// =========================
// GESTION DES ERREURS DE CONNEXION
// En cas d’échec, l’erreur technique est enregistrée
// et un message neutre est affiché à l’utilisateur
// =========================
} catch (PDOException $e) {
    error_log('Erreur de connexion PDO : ' . $e->getMessage());

    http_response_code(500);
    exit('Une erreur technique est survenue. Veuillez réessayer plus tard.');
}