<?php
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<main class="auth-page auth-page--login">
    <section class="auth-hero">
        <div class="auth-hero__inner">
            <h1 class="auth-hero__brand">
                <span class="auth-hero__brand-main">FOURNIER</span>
                <span class="auth-hero__brand-accent"> roux</span>
            </h1>

            <div class="auth-hero__logo-wrap">
                <a
                    href="index.php?page=accueil"
                    class="auth-hero__logo-link"
                    aria-label="Retour à l'accueil">
                    <div class="auth-hero__logo-box">
                        <img
                            src="public/assets/images/logoCreator_imagetologo.jpg"
                            alt="Logo Fournier Roux"
                            class="auth-hero__logo">
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="auth-content">
        <div class="auth-content__inner">
            <header class="auth-header">
                <h1 class="auth-header__title">Nouveau mot de passe</h1>
            </header>

            <?php if (!empty($erreur)): ?>
                <div class="auth-message auth-message--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($succes)): ?>
                <div class="auth-message auth-message--success" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="index.php?page=nouveau-mot-de-passe" novalidate autocomplete="off">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>">

                <div class="auth-form__group">
                    <label class="auth-form__label" for="mot_de_passe">Nouveau mot de passe</label>
                    <input
                        class="auth-form__input"
                        type="password"
                        id="mot_de_passe"
                        name="mot_de_passe"
                        autocomplete="new-password"
                        required
                        value="">
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="confirmation_mot_de_passe">Confirmer le mot de passe</label>
                    <input
                        class="auth-form__input"
                        type="password"
                        id="confirmation_mot_de_passe"
                        name="confirmation_mot_de_passe"
                        autocomplete="new-password"
                        required
                        value="">
                </div>

                <div class="auth-form__submit">
                    <button class="auth-form__button" type="submit">Modifier le mot de passe</button>
                </div>
            </form>

            <div class="auth-divider" aria-hidden="true"></div>

            <section class="auth-register">
                <a class="auth-register__button" href="index.php?page=login">
                    Retour à la connexion
                </a>
            </section>
        </div>
    </section>

    <footer class="auth-footer">
        <p>© 2026 Fournier Roux – Tous droits réservés</p>
    </footer>
</main>