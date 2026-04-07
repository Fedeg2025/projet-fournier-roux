<main>
    <article>
        <h2><?php echo htmlspecialchars($article['titre']); ?></h2>

        <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
            <img src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>"
                 alt="Image de l'article"
                 style="max-width: 500px; height: auto;">
        <?php endif; ?>

        <p>
            <em>Catégories : <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?></em>
        </p>

        <p>
            <small>
                <?php echo htmlspecialchars($article['date_publication']); ?> -
                <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
            </small>
        </p>

        <div>
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>

        <p>
            <a href="index.php?page=articles">← Retour aux actualités</a>
        </p>
    </article>
</main>