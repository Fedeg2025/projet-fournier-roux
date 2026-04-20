<!-- =========================
     GESTION DES MÉDIAS
     ========================= -->

<section class="gestion-media-admin">
    <h2 class="gestion-media-admin__title">Gestion des médias</h2>

    <div class="gestion-media-admin__actions">
        <form method="POST" action="index.php?page=admin&section=medias">
            <button
                class="gestion-media-admin__button"
                type="submit"
                name="delete_unused_media"
                value="1"
            >
                Supprimer les médias non utilisés
            </button>
        </form>
    </div>

    <?php if (empty($medias)): ?>
        <p class="gestion-media-admin__empty">Aucun média trouvé.</p>
    <?php else: ?>
        <form method="POST" action="index.php?page=admin&section=medias" class="gestion-media-admin__form">
            <div class="gestion-media-admin__list">
                <?php foreach ($medias as $media): ?>
                    <div class="gestion-media-admin__item">
                        <div class="gestion-media-admin__checkbox-wrapper">
                            <input
                                type="checkbox"
                                name="media_ids[]"
                                value="<?php echo (int) $media['id_media']; ?>"
                                aria-label="Sélectionner le média <?php echo (int) $media['id_media']; ?>"
                            >
                        </div>

                        <div class="gestion-media-admin__preview">
                            <img
                                class="gestion-media-admin__image"
                                src="public/uploads/<?php echo htmlspecialchars($media['nom_fichier']); ?>"
                                alt=""
                                width="120"
                            >
                        </div>

                        <div class="gestion-media-admin__info">
                            <p><strong>ID :</strong> <?php echo (int) $media['id_media']; ?></p>
                            <p><strong>Fichier :</strong> <?php echo htmlspecialchars($media['nom_fichier']); ?></p>
                            <p><strong>Texte alternatif :</strong> <?php echo !empty($media['alt_text']) ? htmlspecialchars($media['alt_text']) : 'Aucun texte alternatif'; ?></p>
                            <p><strong>Date :</strong> <?php echo htmlspecialchars($media['date_upload']); ?></p>
                            <p><strong>Type :</strong> <?php echo htmlspecialchars($media['type_media']); ?></p>
                            <p><strong>Utilisation :</strong> <?php echo (int) $media['usage_count']; ?> article(s)</p>
                        </div>

                        <div class="gestion-media-admin__single-action">
                            <button
                                class="gestion-media-admin__button gestion-media-admin__button--delete"
                                type="submit"
                                name="delete_media_id"
                                value="<?php echo (int) $media['id_media']; ?>"
                            >
                                Supprimer
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="gestion-media-admin__bulk-actions">
                <button
                    class="gestion-media-admin__button gestion-media-admin__button--delete"
                    type="submit"
                    name="delete_selected_media"
                    value="1"
                >
                    Supprimer la sélection
                </button>
            </div>
        </form>
    <?php endif; ?>
</section>