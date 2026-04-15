<!-- =========================
     PAGE ACTUALITÉS
     Cette vue affiche la liste des articles publiés
     avec pagination, image, extrait et métadonnées
     ========================= -->

<main class="page-actualites">
    <h1 class="page-actualites__title">Actualités</h1>

    <!-- =========================
         CAS AUCUN ARTICLE
         ========================= -->
    <?php if (empty($articles)): ?>
        <p class="page-actualites__empty">Aucun article publié.</p>

    <?php else: ?>

        <!-- =========================
             LISTE DES ARTICLES
             ========================= -->
        <div class="page-actualites__list">
            <?php foreach ($articles as $article): ?>
                <section class="page-actualites__item">

                    <!-- =========================
                         TITRE DE L’ARTICLE
                         ========================= -->
                    <h2 class="page-actualites__item-title">
                        <a
                            class="page-actualites__item-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            <?php echo htmlspecialchars($article['titre']); ?>
                        </a>
                    </h2>

                    <!-- =========================
                         IMAGE PRINCIPALE
                         ========================= -->
                    <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                        <div class="page-actualites__image-wrapper">
                            <img
                                class="page-actualites__image"
                                src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                                alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>"
                            >
                        </div>
                    <?php endif; ?>

                    <!-- =========================
                         CATÉGORIES
                         ========================= -->
                    <p class="page-actualites__categories">
                        <em>
                            Catégories :
                            <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                        </em>
                    </p>

                    <!-- =========================
                         EXTRAIT DE L’ARTICLE
                         ========================= -->
                    <div class="page-actualites__excerpt">
                        <?php
                        $excerpt = mb_substr($article['contenu'], 0, 200);
                        echo nl2br(htmlspecialchars($excerpt));
                        if (mb_strlen($article['contenu']) > 200) {
                            echo '...';
                        }
                        ?>
                    </div>

                    <!-- =========================
                         LIEN VERS LE DÉTAIL
                         ========================= -->
                    <p class="page-actualites__more">
                        <a
                            class="page-actualites__more-link"
                            href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>"
                        >
                            Lire la suite
                        </a>
                    </p>

                    <!-- =========================
                         MÉTADONNÉES
                         ========================= -->
                    <p class="page-actualites__meta">
                        <small>
                            <?php echo htmlspecialchars($article['date_publication']); ?> -
                            <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                        </small>
                    </p>
                </section>
            <?php endforeach; ?>
        </div>

        <!-- =========================
             PAGINATION
             ========================= -->
        <div class="page-actualites__pagination">
            <?php if ($page_articles > 1): ?>
                <a
                    class="page-actualites__pagination-link"
                    href="index.php?page=articles&p=<?php echo $page_articles - 1; ?>"
                >
                    ← Précédent
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages_articles; $i++): ?>
                <a
                    class="page-actualites__pagination-link <?php echo $i === $page_articles ? 'page-actualites__pagination-link--active' : ''; ?>"
                    href="index.php?page=articles&p=<?php echo $i; ?>"
                >
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page_articles < $total_pages_articles): ?>
                <a
                    class="page-actualites__pagination-link"
                    href="index.php?page=articles&p=<?php echo $page_articles + 1; ?>"
                >
                    Suivant →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>