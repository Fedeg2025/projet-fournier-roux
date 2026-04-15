<?php

// =========================
// CHARGEMENT DE LA CONFIGURATION
// =========================
$config = require BASE_PATH . '/config/db-config.php';

$dbHost = $config['host'];
$dbName = $config['dbname'];
$dbUser = $config['user'];
$dbPassword = $config['password'];


// =========================
// CONNEXION À LA BASE DE DONNÉES
// =========================
try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    error_log('Erreur de connexion PDO : ' . $e->getMessage());

    http_response_code(500);
    header('Location: index.php?page=error');
    exit;
}