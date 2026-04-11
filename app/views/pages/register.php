<?php
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<main class="auth-page auth-page--register">
    <section class="auth-content">
        <div class="auth-content__inner">

            <h1>Créer un compte</h1>
            <p>Rejoignez l’espace utilisateur</p>

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

            <form class="auth-form" method="POST" action="index.php?page=register" novalidate>
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>"
                >

                <div class="auth-form__group">
                    <label class="auth-form__label" for="nom">Nom</label>
                    <input
                        class="auth-form__input"
                        type="text"
                        id="nom"
                        name="nom"
                        required
                        value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>"
                    >
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="prenom">Prénom</label>
                    <input
                        class="auth-form__input"
                        type="text"
                        id="prenom"
                        name="prenom"
                        required
                        value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>"
                    >
                </div>

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
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="auth-form__consent">
                    <input
                        class="auth-form__checkbox"
                        type="checkbox"
                        id="register_consent"
                        name="register_consent"
                        required
                        <?php echo isset($_POST['register_consent']) ? 'checked' : ''; ?>
                    >
                    <label class="auth-form__consent-label" for="register_consent">
                        En créant votre compte, vous acceptez les conditions d’utilisation et la
                        <a class="auth-form__link" href="index.php?page=politique-confidentialite">politique de confidentialité</a>.
                    </label>
                </div>

                <div class="auth-form__submit">
                    <button class="auth-form__button" type="submit">S'inscrire</button>
                </div>
            </form>

            <div class="auth-divider" aria-hidden="true"></div>

            <section class="auth-register">
                <p class="auth-register__text">Déjà membre ?</p>
                <a class="auth-register__button" href="index.php?page=login">
                    Se connecter
                </a>
            </section>

        </div>
    </section>
</main>