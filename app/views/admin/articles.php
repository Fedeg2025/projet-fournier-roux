<section class="admin-articles">
    <h2 class="admin-articles__title">Articles publiés</h2>

    <?php if (empty($articles)): ?>
        <p class="admin-articles__empty">Aucun article.</p>
    <?php else: ?>
        <div class="admin-articles__list">
            <?php foreach ($articles as $article): ?>
                <article class="admin-articles__item">
                    <h3 class="admin-articles__item-title">
                        <?php echo htmlspecialchars($article['titre']); ?>
                    </h3>

                    <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                        <div class="admin-articles__image-wrapper">
                            <img
                                class="admin-articles__image"
                                src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                                alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>"
                            >
                        </div>
                    <?php endif; ?>

                    <p class="admin-articles__categories">
                        <em>
                            Catégories :
                            <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                        </em>
                    </p>

                    <div class="admin-articles__content">
                        <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
                    </div>

                    <p class="admin-articles__meta">
                        <small>
                            <?php echo htmlspecialchars($article['date_publication']); ?> -
                            <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                        </small>
                    </p>

                    <div class="admin-articles__actions">
                        <a
                            class="admin-articles__edit-link"
                            href="index.php?page=admin&section=contenus&edit_article=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            Modifier
                        </a>

                        <a
                            class="admin-articles__delete-link"
                            href="index.php?page=admin&section=contenus&confirm_delete=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            Supprimer
                        </a>
                    </div>

                    <?php if (isset($confirm_delete) && $confirm_delete === (int) $article['id_article']): ?>
                        <div class="admin-articles__confirm">
                            <p class="admin-articles__confirm-text">
                                Confirmer la suppression de cet article ?
                            </p>

                            <form
                                class="admin-articles__confirm-form"
                                method="POST"
                                action="index.php?page=admin&section=contenus"
                            >
                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                                >

                                <input
                                    type="hidden"
                                    name="delete_article"
                                    value="<?php echo htmlspecialchars($article['id_article']); ?>"
                                >

                                <button
                                    class="admin-articles__button admin-articles__button--danger"
                                    type="submit"
                                >
                                    Oui, supprimer
                                </button>

                                <a
                                    class="admin-articles__button admin-articles__button--secondary"
                                    href="index.php?page=admin&section=contenus"
                                >
                                    Annuler
                                </a>
                            </form>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="admin-articles__pagination">
            <?php if ($page_articles > 1): ?>
                <a
                    class="admin-articles__pagination-link"
                    href="index.php?page=admin&section=contenus&p=<?php echo $page_articles - 1; ?>"
                >
                    ← Précédent
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages_articles; $i++): ?>
                <a
                    class="admin-articles__pagination-link <?php echo $i === $page_articles ? 'admin-articles__pagination-link--active' : ''; ?>"
                    href="index.php?page=admin&section=contenus&p=<?php echo $i; ?>"
                >
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page_articles < $total_pages_articles): ?>
                <a
                    class="admin-articles__pagination-link"
                    href="index.php?page=admin&section=contenus&p=<?php echo $page_articles + 1; ?>"
                >
                    Suivant →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>