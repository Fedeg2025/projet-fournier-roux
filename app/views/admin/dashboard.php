<!-- =========================
     TABLEAU DE BORD ADMINISTRATEUR
     Cette vue organise les différentes sections
     du back-office : messages, articles et utilisateurs
     ========================= -->

<main class="tableau-bord-admin">
    <h1 class="tableau-bord-admin__title">Back-office administrateur</h1>

    <!-- =========================
         NAVIGATION DU BACK-OFFICE
         ========================= -->
    <nav class="tableau-bord-admin__nav">
        <a
            class="tableau-bord-admin__link <?php echo $section === 'messages' ? 'tableau-bord-admin__link--active' : ''; ?>"
            href="index.php?page=admin&section=messages"
        >
            Messages
        </a>

        <a
            class="tableau-bord-admin__link <?php echo $section === 'articles' ? 'tableau-bord-admin__link--active' : ''; ?>"
            href="index.php?page=admin&section=articles"
        >
            Articles
        </a>

        <a
            class="tableau-bord-admin__link <?php echo $section === 'utilisateurs' ? 'tableau-bord-admin__link--active' : ''; ?>"
            href="index.php?page=admin&section=utilisateurs"
        >
            Utilisateurs
        </a>
    </nav>

    <!-- =========================
         SÉPARATEUR VISUEL
         ========================= -->
    <hr class="tableau-bord-admin__separator">

    <!-- =========================
         CONTENU DU BACK-OFFICE
         ========================= -->
    <section class="tableau-bord-admin__content">

        <!-- =========================
             SECTION MESSAGES
             ========================= -->
        <?php if ($section === 'messages'): ?>
            <div class="tableau-bord-admin__section tableau-bord-admin__section--messages">

                <div class="tableau-bord-admin__block tableau-bord-admin__block--recherche-message">
                    <form method="GET" action="index.php" class="tableau-bord-admin__search-form">
                        <input type="hidden" name="page" value="admin">
                        <input type="hidden" name="section" value="messages">

                        <input
                            class="tableau-bord-admin__search-input"
                            type="date"
                            name="message_date"
                            value="<?php echo htmlspecialchars($messageDate ?? ''); ?>"
                        >

                        <button
                            class="tableau-bord-admin__search-button"
                            type="submit"
                        >
                            Rechercher
                        </button>
                    </form>
                </div>

                <div class="tableau-bord-admin__block tableau-bord-admin__block--messages">
                    <?php require_once BASE_PATH . '/app/views/admin/messages.php'; ?>
                </div>

            </div>
        <?php endif; ?>

        <!-- =========================
             SECTION ARTICLES
             ========================= -->
        <?php if ($section === 'articles'): ?>
            <div class="tableau-bord-admin__section tableau-bord-admin__section--articles">

                <div class="tableau-bord-admin__block tableau-bord-admin__block--formulaire-article">
                    <?php require_once BASE_PATH . '/app/views/admin/article-form.php'; ?>
                </div>

                <div class="tableau-bord-admin__block tableau-bord-admin__block--recherche-article">
                    <form method="GET" action="index.php" class="tableau-bord-admin__search-form">
                        <input type="hidden" name="page" value="admin">
                        <input type="hidden" name="section" value="articles">

                        <input
                            class="tableau-bord-admin__search-input"
                            type="text"
                            name="article_search"
                            placeholder="Titre"
                            value="<?php echo htmlspecialchars($articleSearch ?? ''); ?>"
                        >

                        <input
                            class="tableau-bord-admin__search-input"
                            type="date"
                            name="article_date"
                            value="<?php echo htmlspecialchars($articleDate ?? ''); ?>"
                        >

                        <button
                            class="tableau-bord-admin__search-button"
                            type="submit"
                        >
                            Rechercher
                        </button>
                    </form>
                </div>

                <div class="tableau-bord-admin__block tableau-bord-admin__block--articles">
                    <?php require_once BASE_PATH . '/app/views/admin/articles.php'; ?>
                </div>

            </div>
        <?php endif; ?>

        <!-- =========================
             SECTION UTILISATEURS
             ========================= -->
        <?php if ($section === 'utilisateurs'): ?>
            <div class="tableau-bord-admin__section tableau-bord-admin__section--utilisateurs">

                <div class="tableau-bord-admin__block tableau-bord-admin__block--recherche-utilisateur">
                    <form method="GET" action="index.php" class="tableau-bord-admin__search-form">
                        <input type="hidden" name="page" value="admin">
                        <input type="hidden" name="section" value="utilisateurs">

                        <input
                            class="tableau-bord-admin__search-input"
                            type="text"
                            name="user_search"
                            placeholder="Nom, prénom ou email"
                            value="<?php echo htmlspecialchars($userSearch ?? ''); ?>"
                        >

                        <button
                            class="tableau-bord-admin__search-button"
                            type="submit"
                        >
                            Rechercher
                        </button>
                    </form>
                </div>

                <div class="tableau-bord-admin__block tableau-bord-admin__block--utilisateurs">
                    <?php require_once BASE_PATH . '/app/views/admin/user.php'; ?>
                </div>

            </div>
        <?php endif; ?>

    </section>
</main>