<?php

// =========================
// RÉCUPÉRATION DU TOKEN CSRF
// Ce token est utilisé pour sécuriser le formulaire
// d’inscription
// =========================
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<!-- =========================
     PAGE D’INSCRIPTION
     Cette vue permet à l’utilisateur
     de créer un compte
     ========================= -->

<main class="page-authentification page-authentification--inscription">
    <section class="contenu-authentification">
        <div class="contenu-authentification__inner">

            <!-- =========================
                 TITRE ET INTRODUCTION
                 ========================= -->
            <h1>Créer un compte</h1>
            <p>Rejoignez l’espace utilisateur</p>

            <!-- =========================
                 MESSAGE D’ERREUR
                 ========================= -->
            <?php if (!empty($erreur)): ?>
                <div class="message-authentification message-authentification--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <!-- =========================
                 MESSAGE DE SUCCÈS
                 ========================= -->
            <?php if (!empty($succes)): ?>
                <div class="message-authentification message-authentification--success" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>

            <!-- =========================
                 FORMULAIRE D’INSCRIPTION
                 ========================= -->
            <form class="formulaire-authentification" method="POST" action="index.php?page=register" novalidate>
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>"
                >

                <!-- =========================
                     CHAMP NOM
                     ========================= -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="nom">Nom</label>
                    <input
                        class="formulaire-authentification__input"
                        type="text"
                        id="nom"
                        name="nom"
                        required
                        value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>"
                    >
                </div>

                <!-- =========================
                     CHAMP PRÉNOM
                     ========================= -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="prenom">Prénom</label>
                    <input
                        class="formulaire-authentification__input"
                        type="text"
                        id="prenom"
                        name="prenom"
                        required
                        value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>"
                    >
                </div>

                <!-- =========================
                     CHAMP EMAIL
                     ========================= -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="email">Adresse email</label>
                    <input
                        class="formulaire-authentification__input"
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <!-- =========================
                     CHAMP MOT DE PASSE
                     ========================= -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="mot_de_passe">Mot de passe</label>
                    <input
                        class="formulaire-authentification__input"
                        type="password"
                        id="mot_de_passe"
                        name="mot_de_passe"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <!-- =========================
                     CONSENTEMENT
                     ========================= -->
                <div class="formulaire-authentification__consent">
                    <input
                        class="formulaire-authentification__checkbox"
                        type="checkbox"
                        id="register_consent"
                        name="register_consent"
                        required
                        <?php echo isset($_POST['register_consent']) ? 'checked' : ''; ?>
                    >
                    <label class="formulaire-authentification__consent-label" for="register_consent">
                        En créant votre compte, vous acceptez les conditions d’utilisation et la
                        <a class="formulaire-authentification__link" href="index.php?page=politique-confidentialite">politique de confidentialité</a>.
                    </label>
                </div>

                <!-- =========================
                     BOUTON D’INSCRIPTION
                     ========================= -->
                <div class="formulaire-authentification__submit">
                    <button class="formulaire-authentification__button" type="submit">S'inscrire</button>
                </div>
            </form>

            <!-- =========================
                 SÉPARATEUR VISUEL
                 ========================= -->
            <div class="separateur-authentification" aria-hidden="true"></div>

            <!-- =========================
                 LIEN VERS LA CONNEXION
                 ========================= -->
            <section class="inscription-authentification">
                <p class="inscription-authentification__text">Déjà membre ?</p>
                <a class="inscription-authentification__button" href="index.php?page=login">
                    Se connecter
                </a>
            </section>

        </div>
    </section>
</main>