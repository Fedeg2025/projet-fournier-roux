<?php

// =========================
// CHARGEMENT DU FICHIER .ENV
// Ce fichier permet de récupérer les variables
// d’environnement pour la configuration du projet
// =========================
$config_env = parse_ini_file(BASE_PATH . '/.env');


// =========================
// RETOUR DE LA CONFIGURATION
// On retourne un tableau associatif contenant
// les paramètres de connexion à la base de données
// =========================
return [
    'DB_HOST' => $config_env['DB_HOST'] ?? 'localhost',
    'DB_NAME' => $config_env['DB_NAME'] ?? '',
    'DB_USER' => $config_env['DB_USER'] ?? '',
    'DB_PASS' => $config_env['DB_PASS'] ?? '',
];