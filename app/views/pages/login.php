<?php

// =========================
// RÉCUPÉRATION DU TOKEN CSRF
// Ce token est utilisé pour sécuriser le formulaire
// =========================
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<!-- =========================
     PAGE DE CONNEXION
     Cette vue permet à l’utilisateur
     d’accéder à son compte
     ========================= -->

<main class="page-authentification page-authentification--connexion">
    <section class="contenu-authentification">
        <div class="contenu-authentification__inner">

            <h1>Accéder à votre compte</h1>

            <!-- =========================
                 MESSAGE D’ERREUR
                 ========================= -->
            <?php if (!empty($erreur)): ?>
                <div class="message-authentification message-authentification--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'compte_en_suppression'): ?>
                <div class="message-authentification message-authentification--error" role="alert" aria-live="polite">
                    Votre compte est en cours de suppression. Vous ne pouvez plus vous connecter.
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
                 FORMULAIRE DE CONNEXION
                 ========================= -->
            <form class="formulaire-authentification" method="POST" action="index.php?page=login" novalidate>
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($csrfToken); ?>"
                >

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
                        autocomplete="current-password"
                        required
                    >
                </div>

                <!-- =========================
                     BOUTON DE CONNEXION
                     ========================= -->
                <div class="formulaire-authentification__submit">
                    <button class="formulaire-authentification__button" type="submit">Se connecter</button>
                </div>
            </form>

            <!-- =========================
                 SÉPARATEUR VISUEL
                 ========================= -->
            <div class="separateur-authentification" aria-hidden="true"></div>

            <!-- =========================
                 LIEN VERS L’INSCRIPTION
                 ========================= -->
            <section class="inscription-authentification">
                <p class="inscription-authentification__text">Pas encore de compte ?</p>
                <a class="inscription-authentification__button" href="index.php?page=register">
                    Créer un compte
                </a>
            </section>

        </div>
    </section>
</main>