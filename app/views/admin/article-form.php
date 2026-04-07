<section>
    <h3>
        <?php if ($article_a_modifier): ?>
            Modifier un article
        <?php else: ?>
            Créer un article
        <?php endif; ?>
    </h3>

    <form method="POST" action="index.php?page=admin" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <?php if ($article_a_modifier): ?>
            <input type="hidden" name="id_article" value="<?php echo htmlspecialchars($article_a_modifier['id_article']); ?>">
        <?php endif; ?>

        <label for="titre">Titre :</label><br>
        <input
            type="text"
            name="titre"
            id="titre"
            required
            value="<?php echo $article_a_modifier ? htmlspecialchars($article_a_modifier['titre']) : ''; ?>">
        <br><br>

        <label for="contenu">Contenu :</label><br>
        <textarea name="contenu" id="contenu" required><?php echo $article_a_modifier ? htmlspecialchars($article_a_modifier['contenu']) : ''; ?></textarea>
        <br><br>

        <label>Catégories :</label><br>
        <?php foreach ($categories as $categorie): ?>
            <label>
                <input
                    type="checkbox"
                    name="categories[]"
                    value="<?php echo htmlspecialchars($categorie['id_categorie']); ?>"
                    <?php echo in_array($categorie['id_categorie'], $categories_selectionnees) ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($categorie['nom']); ?>
            </label><br>
        <?php endforeach; ?>
        <br>

        <label for="image">Image de l’article :</label><br>
        <input type="file" name="image" id="image" accept="image/*">
        <br><br>

        <button type="submit">
            <?php if ($article_a_modifier): ?>
                Modifier
            <?php else: ?>
                Créer
            <?php endif; ?>
        </button>
    </form>
</section>