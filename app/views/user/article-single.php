<!-- =========================
     PAGE ARTICLE
     Cette vue affiche le détail complet
     d’un article publié
     ========================= -->

<main class="page-article">
    <article class="page-article__conteneur">

        <!-- =========================
             TITRE DE L’ARTICLE
             ========================= -->
        <h1 class="page-article__titre">
            <?php echo htmlspecialchars($article['titre']); ?>
        </h1>

        <!-- =========================
             IMAGE PRINCIPALE
             ========================= -->
        <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
            <div class="page-article__image-wrapper">
                <img
                    class="page-article__image"
                    src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                    alt="Illustration de l’article <?php echo htmlspecialchars($article['titre']); ?>"
                >
            </div>
        <?php endif; ?>

        <!-- =========================
             CATÉGORIES
             ========================= -->
        <p class="page-article__categories">
            <em>
                Catégories :
                <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
            </em>
        </p>

        <!-- =========================
             MÉTADONNÉES
             ========================= -->
        <p class="page-article__meta">
            <small>
                <?php echo htmlspecialchars($article['date_publication']); ?> -
                <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
            </small>
        </p>

        <!-- =========================
             CONTENU DE L’ARTICLE
             ========================= -->
        <div class="page-article__contenu">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>

        <!-- =========================
             LIEN DE RETOUR
             ========================= -->
        <div class="page-article__retour">
            <a
                class="page-article__retour-lien"
                href="index.php?page=articles"
            >
                ← Retour aux actualités
            </a>
        </div>

    </article>
</main>