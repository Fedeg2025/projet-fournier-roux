<main class="admin-dashboard">
    <h2 class="admin-dashboard__title">Back-office administrateur</h2>

    <nav class="admin-dashboard__nav">
        <a class="admin-dashboard__link" href="index.php?page=admin&section=messages">Messages</a>
        <a class="admin-dashboard__link" href="index.php?page=admin&section=contenus">Contenus</a>
        <a class="admin-dashboard__link" href="index.php?page=admin&section=utilisateurs">Utilisateurs</a>
    </nav>

    <hr class="admin-dashboard__separator">

    <section class="admin-dashboard__content">
        <?php if ($section === 'messages'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--messages">
                <?php require __DIR__ . '/messages.php'; ?>
            </div>
        <?php endif; ?>

        <?php if ($section === 'contenus'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--contenus">
                <div class="admin-dashboard__block admin-dashboard__block--article-form">
                    <?php require __DIR__ . '/article-form.php'; ?>
                </div>

                <div class="admin-dashboard__block admin-dashboard__block--articles">
                    <?php require __DIR__ . '/articles.php'; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($section === 'utilisateurs'): ?>
            <div class="admin-dashboard__section admin-dashboard__section--utilisateurs">
                <div class="admin-dashboard__block admin-dashboard__block--users">
                    <?php require __DIR__ . '/utilisateurs.php'; ?>
                </div>

                <div class="admin-dashboard__block admin-dashboard__block--delete-requests">
                    <?php require __DIR__ . '/demandes-suppression.php'; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>