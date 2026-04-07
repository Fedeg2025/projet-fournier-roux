<section>
    <h3>Articles publiés</h3>

    <?php if (empty($articles)): ?>
        <p>Aucun article.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <p>
                <strong><?php echo htmlspecialchars($article['titre']); ?></strong><br>

                <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                    <img src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>" alt="Image de l'article" style="max-width: 200px;"><br><br>
                <?php endif; ?>

                <em>Catégories :
                    <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                </em><br><br>

                <?php echo nl2br(htmlspecialchars($article['contenu'])); ?><br>
                <small>
                    <?php echo htmlspecialchars($article['date_publication']); ?> -
                    <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                </small><br>

                <a href="index.php?page=admin&edit_article=<?php echo htmlspecialchars($article['id_article']); ?>">
                    Modifier
                </a>

                <form method="POST" action="index.php?page=admin" style="display:inline;" onsubmit="return confirm('Supprimer cet article ?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="delete_article" value="<?php echo htmlspecialchars($article['id_article']); ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </p>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</section>