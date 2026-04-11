<?php

// =========================
// MÉDIAS
// =========================

// Ajouter un média
function createMedia($pdo, $nom_fichier, $type_media = 'image')
{
    $sql = "INSERT INTO media (nom_fichier, type_media) VALUES (?, ?)";
    return $pdo->prepare($sql)->execute([$nom_fichier, $type_media]);
}

// Lier un média à un article
function linkMediaToArticle($pdo, $id_article, $id_media)
{
    $sql = "INSERT INTO contient (id_article, id_media) VALUES (?, ?)";
    return $pdo->prepare($sql)->execute([$id_article, $id_media]);
}

// Récupérer les médias d’un article
function getMediaByArticle($pdo, $id_article)
{
    $sql = "SELECT media.*
            FROM media
            INNER JOIN contient ON media.id_media = contient.id_media
            WHERE contient.id_article = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_article]);
    return $stmt->fetchAll();
}