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

<main id="main-content" class="page-actualites">
    <h1 class="page-actualites__title">Actualités</h1>

    <?php if (empty($articles)): ?>
        <p class="page-actualites__empty">Aucun article publié.</p>

    <?php else: ?>

        <div class="page-actualites__list">
            <?php foreach ($articles as $article): ?>

                <?php
                $medias = getMediaByArticle($pdo, $article['id_article']);
                $mainImage = getMainImage($medias);
                ?>

                <section class="page-actualites__item">

                    <h2 class="page-actualites__item-title">
                        <a
                            class="page-actualites__item-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>">
                            <?php echo htmlspecialchars($article['titre']); ?>
                        </a>
                    </h2>

                    <?php if ($mainImage): ?>
                        <div class="page-actualites__image-wrapper">
                            <img
                                class="page-actualites__image"
                                src="public/uploads/<?php echo htmlspecialchars($mainImage['nom_fichier']); ?>"
                                alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>">
                        </div>
                    <?php endif; ?>

                    <p class="page-actualites__categories">
                        <em>
                            Catégories :
                            <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                        </em>
                    </p>

                    <div class="page-actualites__excerpt">
                        <?php
                        $excerpt = mb_substr($article['contenu'], 0, 200);
                        echo nl2br(htmlspecialchars($excerpt));

                        if (mb_strlen($article['contenu']) > 200) {
                            echo '...';
                        }
                        ?>
                    </div>

                    <p class="page-actualites__more">
                        <a
                            class="page-actualites__more-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>">
                            Lire la suite
                        </a>
                    </p>

                    <p class="page-actualites__meta">
                        <small>
                            <?php echo htmlspecialchars($article['date_publication']); ?> -
                            <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                        </small>
                    </p>
                </section>
            <?php endforeach; ?>
        </div>

        <div class="page-actualites__pagination">
            <?php if ($currentPage > 1): ?>
                <a
                    class="page-actualites__pagination-link"
                    href="index.php?page=articles&p=<?php echo $currentPage - 1; ?>">
                    ← Précédent
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a
                    class="page-actualites__pagination-link <?php echo $i === $currentPage ? 'page-actualites__pagination-link--active' : ''; ?>"
                    href="index.php?page=articles&p=<?php echo $i; ?>">
                    <?php echo htmlspecialchars((string) $i); ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a
                    class="page-actualites__pagination-link"
                    href="index.php?page=articles&p=<?php echo $currentPage + 1; ?>">
                    Suivant →
                </a>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</main>