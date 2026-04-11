<main class="article-page">
    <article class="article-page__container">
        <h1 class="article-page__title">
            <?php echo htmlspecialchars($article['titre']); ?>
        </h1>

        <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
            <div class="article-page__image-wrapper">
                <img
                    class="article-page__image"
                    src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                    alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>"
                >
            </div>
        <?php endif; ?>

        <p class="article-page__categories">
            <em>
                Catégories :
                <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
            </em>
        </p>

        <p class="article-page__meta">
            <small>
                <?php echo htmlspecialchars($article['date_publication']); ?> -
                <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
            </small>
        </p>

        <div class="article-page__content">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>

        <div class="article-page__back">
            <a
                class="article-page__back-link"
                href="index.php?page=articles"
            >
                ← Retour aux actualités
            </a>
        </div>
    </article>
</main>