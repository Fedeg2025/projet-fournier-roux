<?php

$config = require BASE_PATH . '/config/env.php';

$hote = $config['DB_HOST'];
$nom_base = $config['DB_NAME'];
$nom_utilisateur = $config['DB_USER'];
$mot_de_passe = $config['DB_PASS'];

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

} catch (PDOException $e) {
    error_log('Erreur de connexion PDO : ' . $e->getMessage());

    http_response_code(500);
    exit('Une erreur technique est survenue. Veuillez réessayer plus tard.');
}