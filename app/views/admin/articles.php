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

                    <?php if (!empty($articleItem['medias'][0]) && $articleItem['medias'][0]['type_media'] === 'image'): ?>
                        <div class="articles-admin__image-wrapper">
                            <img
                                class="articles-admin__image"
                                src="public/uploads/<?php echo htmlspecialchars($articleItem['medias'][0]['nom_fichier']); ?>"
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

                        <a
                            class="articles-admin__delete-link"
                            href="index.php?page=admin&section=articles&confirm_delete=<?php echo $articleItem['id_article']; ?>"
                        >
                            Supprimer
                        </a>
                    </div>

                    <?php if (isset($confirmDelete) && $confirmDelete === (int) $articleItem['id_article']): ?>
                        <div class="articles-admin__confirm">
                            <p class="articles-admin__confirm-text">
                                Confirmer la suppression de cet article ?
                            </p>

                            <form
                                class="articles-admin__confirm-form"
                                method="POST"
                                action="index.php?page=admin&section=articles"
                            >
                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                                >

                                <input
                                    type="hidden"
                                    name="delete_article"
                                    value="<?php echo $articleItem['id_article']; ?>"
                                >

                                <button
                                    class="articles-admin__button articles-admin__button--danger"
                                    type="submit"
                                >
                                    Oui, supprimer
                                </button>

                                <a
                                    class="articles-admin__button articles-admin__button--secondary"
                                    href="index.php?page=admin&section=articles"
                                >
                                    Annuler
                                </a>
                            </form>
                        </div>
                    <?php endif; ?>

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