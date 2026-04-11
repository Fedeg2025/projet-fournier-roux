<main class="admin-dashboard">
    <h1 class="admin-dashboard__title">Back-office administrateur</h1>

    <nav class="admin-dashboard__nav">
        <a
            class="admin-dashboard__link <?php echo $section === 'messages' ? 'admin-dashboard__link--active' : ''; ?>"
            href="index.php?page=admin&section=messages"
        >
            Messages
        </a>

        <a
            class="admin-dashboard__link <?php echo $section === 'contenus' ? 'admin-dashboard__link--active' : ''; ?>"
            href="index.php?page=admin&section=contenus"
        >
            Contenus
        </a>

        <a
            class="admin-dashboard__link <?php echo $section === 'utilisateurs' ? 'admin-dashboard__link--active' : ''; ?>"
            href="index.php?page=admin&section=utilisateurs"
        >
            Utilisateurs
        </a>
    </nav>

    <hr class="admin-dashboard__separator">

    <section class="admin-dashboard__content">
        <?php if ($section === 'messages'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--messages">
                <?php require_once BASE_PATH . '/app/views/admin/messages.php'; ?>
            </div>
        <?php endif; ?>

        <?php if ($section === 'contenus'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--contenus">
                <div class="admin-dashboard__block admin-dashboard__block--article-form">
                    <?php require_once BASE_PATH . '/app/views/admin/article-form.php'; ?>
                </div>

                <div class="admin-dashboard__block admin-dashboard__block--articles">
                    <?php require_once BASE_PATH . '/app/views/admin/articles.php'; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($section === 'utilisateurs'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--utilisateurs">
                <div class="admin-dashboard__block admin-dashboard__block--users">
                    <?php require_once BASE_PATH . '/app/views/admin/utilisateurs.php'; ?>
                </div>

                <div class="admin-dashboard__block admin-dashboard__block--delete-requests">
                    <?php require_once BASE_PATH . '/app/views/admin/demandes-suppression.php'; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>