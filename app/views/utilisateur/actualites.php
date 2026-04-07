<main>
    <h2>Actualités</h2>

    <?php if (empty($articles_recents)): ?>
        <p>Aucun article publié.</p>
    <?php else: ?>
        <h3>Articles recentes</h3>

        <?php foreach ($articles_recents as $article): ?>
            <section>
                <h3>
                    <a href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>">
                        <?php echo htmlspecialchars($article['titre']); ?>
                    </a>
                </h3>

                <?php if (!empty($article['medias'][0]) && $article['medias'][0]['type_media'] === 'image'): ?>
                    <img src="public/uploads/<?php echo htmlspecialchars($article['medias'][0]['nom_fichier']); ?>" alt="Image de l'article" style="max-width: 300px; height: auto;"><br><br>
                <?php endif; ?>

                <p>
                    <em>
                        Catégories :
                        <?php echo htmlspecialchars($article['categories'] ?? 'Aucune'); ?>
                    </em>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars(mb_substr($article['contenu'], 0, 200))); ?>...
                </p>

                <p>
                    <a href="index.php?page=article&id=<?php echo htmlspecialchars($article['id_article']); ?>">Lire la suite</a>
                </p>

                <small>
                    <?php echo htmlspecialchars($article['date_publication']); ?> -
                    <?php echo htmlspecialchars($article['prenom'] . ' ' . $article['nom']); ?>
                </small>
                <hr>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

    <h3>Anciennes publications</h3>

    <?php if (empty($articles_anciens)): ?>
        <p>Pas d'anciens articles.</p>
    <?php else: ?>
        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="article">

            <label for="id">Choisir un article :</label><br><br>

            <select name="id" id="id">
                <option value="">-- Sélectionner un article --</option>
                <?php foreach ($articles_anciens as $article): ?>
                    <option value="<?php echo htmlspecialchars($article['id_article']); ?>">
                        <?php echo htmlspecialchars($article['titre']); ?> - <?php echo htmlspecialchars(substr($article['date_publication'], 0, 10)); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Ouvrir</button>
        </form>
    <?php endif; ?>
</main>