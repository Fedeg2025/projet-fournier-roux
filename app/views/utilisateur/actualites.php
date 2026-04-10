<main class="articles-page">
    <h2 class="articles-page__title">Actualités</h2>

    <?php if (empty($articles)): ?>
        <p class="articles-page__empty">Aucun article publié.</p>
    <?php else: ?>
        <div class="articles-page__list">
            <?php foreach ($articles as $article): ?>
                <section class="articles-page__item">
                    <h3 class="articles-page__item-title">
                        <a
                            class="articles-page__item-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            <?php echo htmlspecialchars($article['titre']); ?>
                        </a>
                    </h3>

                    <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                        <div class="articles-page__image-wrapper">
                            <img
                                class="articles-page__image"
                                src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                                alt="Image de l'article"
                            >
                        </div>
                    <?php endif; ?>

                    <p class="articles-page__categories">
                        <em>
                            Catégories :
                            <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                        </em>
                    </p>

                    <div class="articles-page__excerpt">
                        <?php echo nl2br(htmlspecialchars(mb_substr($article['contenu'], 0, 200))); ?>...
                    </div>

                    <p class="articles-page__more">
                        <a
                            class="articles-page__more-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            Lire la suite
                        </a>
                    </p>

                    <p class="articles-page__meta">
                        <small>
                            <?php echo htmlspecialchars($article['date_publication']); ?> -
                            <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                        </small>
                    </p>
                </section>
            <?php endforeach; ?>
        </div>

        <div class="articles-page__pagination">
            <?php if ($page_articles > 1): ?>
                <a
                    class="articles-page__pagination-link"
                    href="index.php?page=articles&p=<?php echo $page_articles - 1; ?>"
                >
                    ← Précédent
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages_articles; $i++): ?>
                <a
                    class="articles-page__pagination-link <?php echo ($i === $page_articles) ? 'is-active' : ''; ?>"
                    href="index.php?page=articles&p=<?php echo $i; ?>"
                >
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page_articles < $total_pages_articles): ?>
                <a
                    class="articles-page__pagination-link"
                    href="index.php?page=articles&p=<?php echo $page_articles + 1; ?>"
                >
                    Suivant →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>