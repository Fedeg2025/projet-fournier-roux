<?php require_once BASE_PATH . '/app/models/media.php'; ?>

<?php
/*
 * Cette fonction retourne l’image principale
 * ou la première image disponible
 */
function getMainImage(array $medias): ?array
{
    foreach ($medias as $media) {
        if (!empty($media['image_principale'])) {
            return $media;
        }
    }

    return $medias[0] ?? null;
}
?>

<section class="articles-admin">
    <h2 class="articles-admin__title">Articles publiés</h2>

    <?php if (empty($articles)): ?>
        <p class="articles-admin__empty">Aucun article.</p>

    <?php else: ?>

        <div class="articles-admin__list">
            <?php foreach ($articles as $articleItem): ?>

                <?php
                $medias = getMediaByArticle($pdo, $articleItem['id_article']);
                $mainImage = getMainImage($medias);
                ?>

                <article class="articles-admin__item">

                    <h3 class="articles-admin__item-title">
                        <?php echo htmlspecialchars($articleItem['titre']); ?>
                    </h3>

                    <?php if (!empty($mainImage)): ?>
                        <div class="articles-admin__image-wrapper">
                            <img
                                class="articles-admin__image"
                                src="public/uploads/<?php echo htmlspecialchars($mainImage['nom_fichier']); ?>"
                                alt="Illustration de l’article <?php echo htmlspecialchars($articleItem['titre']); ?>">
                        </div>
                    <?php endif; ?>

                    <p class="articles-admin__categories">
                        <em>
                            Catégories :
                            <?php echo htmlspecialchars($articleItem['categories'] ?? 'Aucune'); ?>
                        </em>
                    </p>

                    <div class="articles-admin__content">
                        <?php echo nl2br(htmlspecialchars($articleItem['contenu'])); ?>
                    </div>

                    <p class="articles-admin__meta">
                        <small>
                            <?php echo htmlspecialchars($articleItem['date_publication']); ?> -
                            <?php echo htmlspecialchars($articleItem['prenom'] . ' ' . $articleItem['nom']); ?>
                        </small>
                    </p>

                    <div class="articles-admin__actions">
                        <a
                            class="articles-admin__edit-link"
                            href="index.php?page=admin&section=articles&edit_article=<?php echo $articleItem['id_article']; ?>">
                            Modifier
                        </a>

                        <form method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input
                                type="hidden"
                                name="delete_article"
                                value="<?php echo $articleItem['id_article']; ?>">
                            <button class="articles-admin__delete-link" type="submit">
                                Supprimer
                            </button>
                        </form>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>