<?php

// =========================
// MODÈLE CATEGORY
// Ce fichier contient les fonctions
// liées aux catégories d’articles
// =========================


// =========================
// RÉCUPÉRER TOUTES LES CATÉGORIES
// Retourne la liste des catégories
// triées par ordre alphabétique
// =========================
function getAllCategories($pdo)
{
    try {
        $sql = "SELECT id_categorie, nom
                FROM categorie
                ORDER BY nom ASC";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getAllCategories : ' . $e->getMessage());
        return [];
    }
}


// =========================
// RÉCUPÉRER UNE CATÉGORIE PAR ID
// Retourne une catégorie selon
// son identifiant
// =========================
function getCategoryById($pdo, $categoryId)
{
    try {
        $sql = "SELECT id_categorie, nom
                FROM categorie
                WHERE id_categorie = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$categoryId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur getCategoryById : ' . $e->getMessage());
        return null;
    }
}


// =========================
// CRÉER UNE CATÉGORIE
// Enregistre une nouvelle catégorie
// =========================
function createCategory($pdo, $name)
{
    try {
        $sql = "INSERT INTO categorie (nom) VALUES (?)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$name]);
    } catch (PDOException $e) {
        error_log('Erreur createCategory : ' . $e->getMessage());
        return false;
    }
}


// =========================
// METTRE À JOUR UNE CATÉGORIE
// Modifie le nom d’une catégorie
// =========================
function updateCategory($pdo, $categoryId, $name)
{
    try {
        $sql = "UPDATE categorie
                SET nom = ?
                WHERE id_categorie = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$name, $categoryId]);
    } catch (PDOException $e) {
        error_log('Erreur updateCategory : ' . $e->getMessage());
        return false;
    }
}


// =========================
// SUPPRIMER UNE CATÉGORIE
// Supprime une catégorie
// =========================
function deleteCategory($pdo, $categoryId)
{
    try {
        $sql = "DELETE FROM categorie WHERE id_categorie = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$categoryId]);
    } catch (PDOException $e) {
        error_log('Erreur deleteCategory : ' . $e->getMessage());
        return false;
    }
}