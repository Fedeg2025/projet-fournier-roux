<section class="admin-article-form">
    <h3 class="admin-article-form__title">
        <?php if ($article_a_modifier): ?>
            Modifier un article
        <?php else: ?>
            Créer un article
        <?php endif; ?>
    </h3>

    <form
        class="admin-article-form__form"
        method="POST"
        action="index.php?page=admin&section=contenus"
        enctype="multipart/form-data"
    >
        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
        >

        <?php if ($article_a_modifier): ?>
            <input
                type="hidden"
                name="id_article"
                value="<?php echo htmlspecialchars($article_a_modifier['id_article']); ?>"
            >
        <?php endif; ?>

        <div class="admin-article-form__group">
            <label class="admin-article-form__label" for="titre">Titre :</label>
            <input
                class="admin-article-form__input"
                type="text"
                name="titre"
                id="titre"
                required
                value="<?php echo $article_a_modifier ? htmlspecialchars($article_a_modifier['titre']) : ''; ?>"
            >
        </div>

        <div class="admin-article-form__group">
            <label class="admin-article-form__label" for="contenu">Contenu :</label>
            <textarea
                class="admin-article-form__textarea"
                name="contenu"
                id="contenu"
                rows="8"
                required
            ><?php echo $article_a_modifier ? htmlspecialchars($article_a_modifier['contenu']) : ''; ?></textarea>
        </div>

        <fieldset class="admin-article-form__group admin-article-form__fieldset">
            <legend class="admin-article-form__label">Catégories :</legend>

            <div class="admin-article-form__categories">
                <?php foreach ($categories as $categorie): ?>
                    <label class="admin-article-form__category">
                        <input
                            class="admin-article-form__checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="<?php echo htmlspecialchars($categorie['id_categorie']); ?>"
                            <?php echo in_array($categorie['id_categorie'], $categories_selectionnees) ? 'checked' : ''; ?>
                        >
                        <span class="admin-article-form__category-name">
                            <?php echo htmlspecialchars($categorie['nom']); ?>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <div class="admin-article-form__group">
            <label class="admin-article-form__label" for="image">Image de l’article :</label>
            <input
                class="admin-article-form__file"
                type="file"
                name="image"
                id="image"
                accept="image/*"
            >
        </div>

        <div class="admin-article-form__actions">
            <button class="admin-article-form__button" type="submit">
                <?php if ($article_a_modifier): ?>
                    Modifier
                <?php else: ?>
                    Créer
                <?php endif; ?>
            </button>
        </div>
    </form>
</section>