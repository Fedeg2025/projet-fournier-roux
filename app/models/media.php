<?php

// =========================
// MODÈLE MÉDIA
// Ce fichier contient les fonctions
// liées aux médias des articles
// =========================


// =========================
// AJOUTER UN MÉDIA
// Cette fonction enregistre un média
// dans la table media
// Paramètres :
// - $pdo : connexion à la base de données
// - $fileName : nom du fichier
// - $mediaType : type du média
// Retour : true si l’enregistrement réussit, sinon false
// =========================
function createMedia($pdo, $fileName, $mediaType = 'image')
{
    try {
        $sql = "INSERT INTO media (nom_fichier, type_media) VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$fileName, $mediaType]);
    } catch (PDOException $e) {
        error_log('Erreur createMedia : ' . $e->getMessage());
        return false;
    }
}


// =========================
// LIER UN MÉDIA À UN ARTICLE
// Cette fonction crée le lien
// entre un article et un média
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// - $mediaId : identifiant du média
// Retour : true si l’enregistrement réussit, sinon false
// =========================
function linkMediaToArticle($pdo, $articleId, $mediaId)
{
    try {
        $sql = "INSERT INTO contient (id_article, id_media) VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$articleId, $mediaId]);
    } catch (PDOException $e) {
        error_log('Erreur linkMediaToArticle : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER LES MÉDIAS D’UN ARTICLE
// Cette fonction retourne tous les médias
// associés à un article
// Paramètres :
// - $pdo : connexion à la base de données
// - $articleId : identifiant de l’article
// Retour : tableau des médias ou tableau vide si erreur
// =========================
function getMediaByArticle($pdo, $articleId)
{
    try {
        $sql = "SELECT media.*
                FROM media
                INNER JOIN contient ON media.id_media = contient.id_media
                WHERE contient.id_article = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$articleId]);

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erreur getMediaByArticle : ' . $e->getMessage());
        return [];
    }
}