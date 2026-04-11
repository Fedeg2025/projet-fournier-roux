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
// =========================
function createMedia($pdo, $nom_fichier, $type_media = 'image')
{
    $sql = "INSERT INTO media (nom_fichier, type_media) VALUES (?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$nom_fichier, $type_media]);
}


// =========================
// LIER UN MÉDIA À UN ARTICLE
// Cette fonction crée le lien entre
// un article et un média
// =========================
function linkMediaToArticle($pdo, $id_article, $id_media)
{
    $sql = "INSERT INTO contient (id_article, id_media) VALUES (?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_article, $id_media]);
}


// =========================
// RÉCUPÉRER LES MÉDIAS D’UN ARTICLE
// Cette fonction retourne tous les médias
// associés à un article
// =========================
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