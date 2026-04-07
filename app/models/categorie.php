<?php

// Récupère toutes les catégories
function getAllCategories(PDO $pdo): array
{
    $sql = "SELECT id_categorie, nom FROM categorie ORDER BY nom ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}