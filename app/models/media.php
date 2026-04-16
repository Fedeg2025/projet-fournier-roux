<?php

// =========================
// MODÈLE MEDIA
// Gestion simple des médias
// =========================


// =========================
// AJOUTER UN MEDIA
// Enregistre un média dans la table media
// et retourne son identifiant
// =========================
function createMedia($pdo, $fileName, $mediaType = 'image')
{
    $sql = "INSERT INTO media (nom_fichier, type_media) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fileName, $mediaType]);

    return $pdo->lastInsertId();
}


// =========================
// LIER UN MEDIA À UN ARTICLE
// Crée l’association entre un article et un média
// avec un ordre et un indicateur d’image principale
// =========================
function linkMediaToArticle($pdo, $articleId, $mediaId, $order = 1, $isMainImage = 0)
{
    $sql = "INSERT INTO contient (id_article, id_media, ordre, image_principale)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $articleId,
        $mediaId,
        $order,
        $isMainImage
    ]);
}


// =========================
// RÉCUPÉRER LES MÉDIAS D’UN ARTICLE
// Retourne tous les médias associés à un article
// triés par image principale puis par ordre
// =========================
function getMediaByArticle($pdo, $articleId)
{
    $sql = "SELECT media.*, contient.ordre, contient.image_principale
            FROM media
            INNER JOIN contient ON media.id_media = contient.id_media
            WHERE contient.id_article = ?
            ORDER BY contient.image_principale DESC, contient.ordre ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$articleId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// =========================
// SUPPRIMER LE LIEN ENTRE UN ARTICLE ET UN MEDIA
// Retire uniquement l’association dans contient
// =========================
function unlinkMediaFromArticle($pdo, $articleId, $mediaId)
{
    $sql = "DELETE FROM contient WHERE id_article = ? AND id_media = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$articleId, $mediaId]);
}


// =========================
// DÉFINIR L’IMAGE PRINCIPALE D’UN ARTICLE
// Met toutes les images de l’article à 0
// puis définit le média choisi comme principal
// =========================
function setMainMedia($pdo, $articleId, $mediaId)
{
    $resetSql = "UPDATE contient
                 SET image_principale = 0
                 WHERE id_article = ?";
    $resetStmt = $pdo->prepare($resetSql);
    $resetStmt->execute([$articleId]);

    $updateSql = "UPDATE contient
                  SET image_principale = 1
                  WHERE id_article = ? AND id_media = ?";
    $updateStmt = $pdo->prepare($updateSql);

    return $updateStmt->execute([$articleId, $mediaId]);
}


// =========================
// COMPTER LE NOMBRE D’UTILISATIONS D’UN MEDIA
// Permet de savoir si un média est encore lié
// à un ou plusieurs articles
// =========================
function countMediaUsage($pdo, $mediaId)
{
    $sql = "SELECT COUNT(*) FROM contient WHERE id_media = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mediaId]);

    return (int) $stmt->fetchColumn();
}


// =========================
// SUPPRIMER UN MEDIA
// Supprime le média uniquement s’il n’est plus utilisé
// =========================
function deleteMedia($pdo, $mediaId)
{
    if (countMediaUsage($pdo, $mediaId) > 0) {
        return false;
    }

    $sql = "DELETE FROM media WHERE id_media = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$mediaId]);
}