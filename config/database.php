<?php

require_once __DIR__ . '/env.php';

$hote = $_ENV['DB_HOST'];
$nom_base = $_ENV['DB_NAME'];
$nom_utilisateur = $_ENV['DB_USER'];
$mot_de_passe = $_ENV['DB_PASS'];

try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$nom_base;charset=utf8mb4",
        $nom_utilisateur,
        $mot_de_passe
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}