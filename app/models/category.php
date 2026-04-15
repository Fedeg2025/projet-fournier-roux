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
// Paramètre :
// - $pdo : connexion à la base de données
// Retour : tableau des catégories ou tableau vide si erreur
// =========================
function getAllCategories($pdo)
{
    try {
        $sql = "SELECT id_categorie, nom FROM categorie ORDER BY nom ASC";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getAllCategories : ' . $e->getMessage());
        return [];
    }
}