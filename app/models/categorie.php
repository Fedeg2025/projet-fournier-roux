<?php

// =========================
// MODÈLE CATÉGORIE
// Ce fichier contient les fonctions
// liées aux catégories d’articles
// =========================


// =========================
// RÉCUPÉRER TOUTES LES CATÉGORIES
// Cette fonction retourne la liste des catégories
// triées par ordre alphabétique
// =========================
function getAllCategories(PDO $pdo): array
{
    $sql = "SELECT id_categorie, nom FROM categorie ORDER BY nom ASC";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}