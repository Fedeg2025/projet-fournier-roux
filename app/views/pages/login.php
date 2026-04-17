<!-- =========================
     PAGE DE CONNEXION
     Cette vue permet à l’utilisateur
     d’accéder à son compte
     ========================= -->

<main id="main-content" class="page-authentification page-authentification--connexion">
    <section class="contenu-authentification">
        <div class="contenu-authentification__inner">

            <h1>Accéder à votre compte</h1>

            <!-- MESSAGE D’ERREUR -->
            <?php if (!empty($erreur)): ?>
                <div class="message-authentification message-authentification--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <!-- MESSAGE DE SUCCÈS -->
            <?php if (!empty($succes)): ?>
                <div class="message-authentification message-authentification--success" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>

            <!-- FORMULAIRE -->
            <form class="formulaire-authentification" method="POST" action="index.php?page=login">

                <!-- EMAIL -->
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

                <!-- MOT DE PASSE -->
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

                <!-- BOUTON -->
                <div class="formulaire-authentification__submit">
                    <button class="formulaire-authentification__button" type="submit">Se connecter</button>
                </div>
            </form>

            <div class="separateur-authentification" aria-hidden="true"></div>

            <section class="inscription-authentification">
                <p class="inscription-authentification__text">Pas encore de compte ?</p>
                <a class="inscription-authentification__button" href="index.php?page=register">
                    Créer un compte
                </a>
            </section>

        </div>
    </section>
</main>