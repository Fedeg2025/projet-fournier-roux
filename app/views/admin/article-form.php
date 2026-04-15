<!-- =========================
     FORMULAIRE ADMIN - ARTICLE
     Permet de créer ou modifier un article
     ========================= -->

<section class="formulaire-article-admin">
    <!-- =========================
         TITRE DYNAMIQUE
         ========================= -->
    <h2 class="formulaire-article-admin__title">
        <?php echo $articleToEdit ? 'Modifier un article' : 'Créer un article'; ?>
    </h2>

    <!-- =========================
         FORMULAIRE PRINCIPAL
         enctype requis pour l’upload d’image
         ========================= -->
    <form
        class="formulaire-article-admin__form"
        method="POST"
        action="index.php?page=admin&section=articles"
        enctype="multipart/form-data"
    >
        <!-- =========================
             TOKEN CSRF
             ========================= -->
        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
        >

        <!-- =========================
             ID ARTICLE (mode édition)
             ========================= -->
        <?php if ($articleToEdit): ?>
            <input
                type="hidden"
                name="id_article"
                value="<?php echo htmlspecialchars($articleToEdit['id_article']); ?>"
            >
        <?php endif; ?>

        <!-- =========================
             CHAMP TITRE
             ========================= -->
        <div class="formulaire-article-admin__group">
            <label class="formulaire-article-admin__label" for="titre">Titre :</label>
            <input
                class="formulaire-article-admin__input"
                type="text"
                name="titre"
                id="titre"
                required
                value="<?php echo $articleToEdit ? htmlspecialchars($articleToEdit['titre']) : ''; ?>"
            >
        </div>

        <!-- =========================
             CHAMP CONTENU
             ========================= -->
        <div class="formulaire-article-admin__group">
            <label class="formulaire-article-admin__label" for="contenu">Contenu :</label>
            <textarea
                class="formulaire-article-admin__textarea"
                name="contenu"
                id="contenu"
                rows="8"
                required
            ><?php echo $articleToEdit ? htmlspecialchars($articleToEdit['contenu']) : ''; ?></textarea>
        </div>

        <!-- =========================
             CATÉGORIES
             ========================= -->
        <fieldset class="formulaire-article-admin__group formulaire-article-admin__fieldset">
            <legend class="formulaire-article-admin__label">Catégories :</legend>

            <p class="formulaire-article-admin__help">
                Sélectionnez une ou plusieurs catégories.
            </p>

            <div class="formulaire-article-admin__categories">
                <?php foreach ($categories as $categoryItem): ?>
                    <label class="formulaire-article-admin__category">
                        <input
                            class="formulaire-article-admin__checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="<?php echo htmlspecialchars($categoryItem['id_categorie']); ?>"
                            <?php echo in_array($categoryItem['id_categorie'], $selectedCategories, true) ? 'checked' : ''; ?>
                        >
                        <span class="formulaire-article-admin__category-name">
                            <?php echo htmlspecialchars($categoryItem['nom']); ?>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <!-- =========================
             UPLOAD IMAGE
             ========================= -->
        <div class="formulaire-article-admin__group">
            <label class="formulaire-article-admin__label" for="image">Image de l’article :</label>
            <input
                class="formulaire-article-admin__file"
                type="file"
                name="image"
                id="image"
                accept="image/jpeg,image/png,image/webp,image/gif"
            >
            <p class="formulaire-article-admin__help">
                Champ optionnel. Formats acceptés : JPG, PNG, WEBP, GIF.
            </p>
        </div>

        <!-- =========================
             BOUTON D’ACTION
             ========================= -->
        <div class="formulaire-article-admin__actions">
            <button
                class="formulaire-article-admin__button <?php echo $articleToEdit ? 'formulaire-article-admin__button--edit' : 'formulaire-article-admin__button--create'; ?>"
                type="submit"
            >
                <?php echo $articleToEdit ? 'Enregistrer les modifications' : 'Créer l’article'; ?>
            </button>
        </div>
    </form>
</section>