<?php

// =====================================================
// ===================== MÉDIAS =========================
// =====================================================

/**
 * Supprime un média simple.
 * Cette action vérifie que la requête utilise
 * bien la méthode POST avant de traiter la suppression.
 */
if (isset($_POST['delete_media_id'])) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin&section=medias');
        exit;
    }

    $mediaId = (int) $_POST['delete_media_id'];

    if ($mediaId > 0) {
        deleteMediaCompletely($pdo, $mediaId);
    }

    header('Location: index.php?page=admin&section=medias');
    exit;
}


/**
 * Supprime plusieurs médias sélectionnés.
 * Cette action est sécurisée en vérifiant
 * la méthode POST avant traitement.
 */
if (isset($_POST['delete_selected_media'])) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin&section=medias');
        exit;
    }

    $selectedMediaIds = $_POST['media_ids'] ?? [];

    if (is_array($selectedMediaIds)) {
        foreach ($selectedMediaIds as $mediaId) {
            $mediaId = (int) $mediaId;

            if ($mediaId > 0) {
                deleteMediaCompletely($pdo, $mediaId);
            }
        }
    }

    header('Location: index.php?page=admin&section=medias');
    exit;
}


/**
 * Supprime les médias non utilisés.
 * Cette action contrôle la méthode POST
 * pour éviter les accès directs non autorisés.
 */
if (isset($_POST['delete_unused_media'])) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin&section=medias');
        exit;
    }

    $unusedMedias = getUnusedMedia($pdo);

    foreach ($unusedMedias as $media) {
        deleteMediaCompletely($pdo, (int) $media['id_media']);
    }

    header('Location: index.php?page=admin&section=medias');
    exit;
}


/**
 * Récupère tous les médias.
 */
$medias = getAllMedia($pdo);