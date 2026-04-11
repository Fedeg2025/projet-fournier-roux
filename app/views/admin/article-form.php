<!-- =========================
     FORMULAIRE ADMIN - ARTICLE
     Permet de créer ou modifier un article
     ========================= -->

<section class="admin-article-form">

    <!-- =========================
         TITRE DYNAMIQUE
         ========================= -->
    <h2 class="admin-article-form__title">
        <?php echo $article_a_modifier ? 'Modifier un article' : 'Créer un article'; ?>
    </h2>

    <!-- =========================
         FORMULAIRE PRINCIPAL
         enctype requis pour upload image
         ========================= -->
    <form
        class="admin-article-form__form"
        method="POST"
        action="index.php?page=admin&section=contenus"
        enctype="multipart/form-data"
    >

        <!-- =========================
             TOKEN CSRF (sécurité)
             ========================= -->
        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
        >

        <!-- =========================
             ID ARTICLE (mode édition)
             ========================= -->
        <?php if ($article_a_modifier): ?>
            <input
                type="hidden"
                name="id_article"
                value="<?php echo htmlspecialchars($article_a_modifier['id_article']); ?>"
            >
        <?php endif; ?>

        <!-- =========================
             CHAMP TITRE
             ========================= -->
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

        <!-- =========================
             CHAMP CONTENU
             ========================= -->
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

        <!-- =========================
             CATÉGORIES (checkbox multiples)
             ========================= -->
        <fieldset class="admin-article-form__group admin-article-form__fieldset">
            <legend class="admin-article-form__label">Catégories :</legend>

            <p class="admin-article-form__help">
                Sélectionnez une ou plusieurs catégories.
            </p>

            <div class="admin-article-form__categories">
                <?php foreach ($categories as $categorie): ?>
                    <label class="admin-article-form__category">
                        <input
                            class="admin-article-form__checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="<?php echo htmlspecialchars($categorie['id_categorie']); ?>"
                            <?php echo in_array($categorie['id_categorie'], $categories_selectionnees, true) ? 'checked' : ''; ?>
                        >
                        <span class="admin-article-form__category-name">
                            <?php echo htmlspecialchars($categorie['nom']); ?>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <!-- =========================
             UPLOAD IMAGE (optionnel)
             ========================= -->
        <div class="admin-article-form__group">
            <label class="admin-article-form__label" for="image">Image de l’article :</label>
            <input
                class="admin-article-form__file"
                type="file"
                name="image"
                id="image"
                accept="image/*"
            >
            <p class="admin-article-form__help">
                Champ optionnel.
            </p>
        </div>

        <!-- =========================
             BOUTON (création ou modification)
             ========================= -->
        <div class="admin-article-form__actions">
            <button
                class="admin-article-form__button <?php echo $article_a_modifier ? 'admin-article-form__button--edit' : 'admin-article-form__button--create'; ?>"
                type="submit"
            >
                <?php echo $article_a_modifier ? 'Enregistrer les modifications' : 'Créer l’article'; ?>
            </button>
        </div>

    </form>
</section>