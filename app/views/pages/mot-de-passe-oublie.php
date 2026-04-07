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
                <h1 class="auth-header__title">Mot de passe oublié</h1>
            </header>

            <?php if (!empty($erreur)): ?>
                <div class="auth-message auth-message--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="index.php?page=mot-de-passe-oublie" novalidate>
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>">

                <div class="auth-form__group">
                    <label class="auth-form__label" for="email">Adresse email</label>
                    <input
                        class="auth-form__input"
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="auth-form__submit">
                    <button class="auth-form__button" type="submit">Continuer</button>
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