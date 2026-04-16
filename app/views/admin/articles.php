<section class="articles-admin">
    <h2 class="articles-admin__title">Articles publiés</h2>

    <?php if (empty($articles)): ?>
        <p class="articles-admin__empty">Aucun article.</p>

    <?php else: ?>

        <div class="articles-admin__list">
            <?php foreach ($articles as $articleItem): ?>
                <article class="articles-admin__item">

                    <h3 class="articles-admin__item-title">
                        <?php echo htmlspecialchars($articleItem['titre']); ?>
                    </h3>

                    <?php if (!empty($articleItem['nom_fichier_image'])): ?>
                        <div class="articles-admin__image-wrapper">
                            <img
                                class="articles-admin__image"
                                src="public/uploads/<?php echo htmlspecialchars($articleItem['nom_fichier_image']); ?>"
                                alt="Illustration de l’article <?php echo htmlspecialchars($articleItem['titre']); ?>"
                            >
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
                            href="index.php?page=admin&section=articles&edit_article=<?php echo $articleItem['id_article']; ?>"
                        >
                            Modifier
                        </a>

                        <!-- Formulaire de suppression -->
                        <form method="POST" onsubmit="return confirm('Supprimer cet article ?');" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input
                                type="hidden"
                                name="delete_article"
                                value="<?php echo $articleItem['id_article']; ?>"
                            >
                            <button class="articles-admin__delete-link" type="submit">
                                Supprimer
                            </button>
                        </form>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($totalArticlePages) && $totalArticlePages > 1): ?>
            <div class="articles-admin__pagination">

                <?php if ($currentArticlePage > 1): ?>
                    <a
                        class="articles-admin__pagination-link"
                        href="index.php?page=admin&section=articles&p=<?php echo $currentArticlePage - 1; ?>"
                    >
                        ← Précédent
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalArticlePages; $i++): ?>
                    <a
                        class="articles-admin__pagination-link <?php echo $i === $currentArticlePage ? 'articles-admin__pagination-link--active' : ''; ?>"
                        href="index.php?page=admin&section=articles&p=<?php echo $i; ?>"
                    >
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentArticlePage < $totalArticlePages): ?>
                    <a
                        class="articles-admin__pagination-link"
                        href="index.php?page=admin&section=articles&p=<?php echo $currentArticlePage + 1; ?>"
                    >
                        Suivant →
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    <?php endif; ?>
</section>