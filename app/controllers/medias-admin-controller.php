<?php

// =====================================================
// ===================== MÉDIAS =========================
// =====================================================

/**
 * Supprime un média simple.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_media_id'])) {
    $mediaId = (int) $_POST['delete_media_id'];

    if ($mediaId > 0) {
        deleteMediaCompletely($pdo, $mediaId);
    }

    header('Location: index.php?page=admin&section=medias');
    exit;
}


/**
 * Supprime plusieurs médias sélectionnés.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected_media'])) {
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
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_unused_media'])) {
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