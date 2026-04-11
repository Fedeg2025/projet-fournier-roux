<!-- =========================
     PAGE ARTICLE
     Cette vue affiche le détail complet
     d’un article publié
     ========================= -->

<main class="article-page">
    <article class="article-page__container">

        <!-- =========================
             TITRE DE L’ARTICLE
             ========================= -->
        <h1 class="article-page__title">
            <?php echo htmlspecialchars($article['titre']); ?>
        </h1>

        <!-- =========================
             IMAGE PRINCIPALE
             ========================= -->
        <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
            <div class="article-page__image-wrapper">
                <img
                    class="article-page__image"
                    src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                    alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>"
                >
            </div>
        <?php endif; ?>

        <!-- =========================
             CATÉGORIES
             ========================= -->
        <p class="article-page__categories">
            <em>
                Catégories :
                <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
            </em>
        </p>

        <!-- =========================
             MÉTADONNÉES
             ========================= -->
        <p class="article-page__meta">
            <small>
                <?php echo htmlspecialchars($article['date_publication']); ?> -
                <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
            </small>
        </p>

        <!-- =========================
             CONTENU DE L’ARTICLE
             ========================= -->
        <div class="article-page__content">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>

        <!-- =========================
             LIEN DE RETOUR
             ========================= -->
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