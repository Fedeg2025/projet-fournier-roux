<section class="admin-articles">
    <h3 class="admin-articles__title">Articles publiés</h3>

    <?php if (empty($articles)): ?>
        <p class="admin-articles__empty">Aucun article.</p>
    <?php else: ?>
        <div class="admin-articles__list">
            <?php foreach ($articles as $article): ?>
                <article class="admin-articles__item">
                    <h4 class="admin-articles__item-title">
                        <?php echo htmlspecialchars($article['titre']); ?>
                    </h4>

                    <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                        <div class="admin-articles__image-wrapper">
                            <img
                                class="admin-articles__image"
                                src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                                alt="Image de l'article"
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

                        <form
                            class="admin-articles__delete-form"
                            method="POST"
                            action="index.php?page=admin&section=contenus"
                            onsubmit="return confirm('Supprimer cet article ?');"
                        >
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                            >

                            <input
                                type="hidden"
                                name="delete_article"
                                value="<?php echo htmlspecialchars($article['id_article']); ?>"
                            >

                            <button class="admin-articles__delete-button" type="submit">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="admin-articles__pagination">
            <?php if ($page_articles > 1): ?>
                <a href="index.php?page=admin&section=contenus&p=<?php echo $page_articles - 1; ?>">
                    ← Précédent
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages_articles; $i++): ?>
                <a href="index.php?page=admin&section=contenus&p=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page_articles < $total_pages_articles): ?>
                <a href="index.php?page=admin&section=contenus&p=<?php echo $page_articles + 1; ?>">
                    Suivant →
                </a>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</section>