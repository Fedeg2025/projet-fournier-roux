<?php
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<main class="auth-page auth-page--login">
    <section class="auth-content">
        <div class="auth-content__inner">

            <h1>Accéder à votre compte</h1>

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

            <form class="auth-form" method="POST" action="index.php?page=login" novalidate>
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>"
                >

                <div class="auth-form__group">
                    <label class="auth-form__label" for="email">Adresse email</label>
                    <input
                        class="auth-form__input"
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="mot_de_passe">Mot de passe</label>
                    <input
                        class="auth-form__input"
                        type="password"
                        id="mot_de_passe"
                        name="mot_de_passe"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="auth-form__submit">
                    <button class="auth-form__button" type="submit">Se connecter</button>
                </div>
            </form>

            <div class="auth-divider" aria-hidden="true"></div>

            <section class="auth-register">
                <a class="auth-register__button" href="index.php?page=register">
                    Créer un compte
                </a>
            </section>

        </div>
    </section>
</main>