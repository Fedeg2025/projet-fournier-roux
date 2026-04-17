<!-- =========================
     PAGE CONTACT
     Cette vue affiche le formulaire de contact
     ainsi que les informations de contact de l’association
     ========================= -->

<main id="main-content" class="page-contact page-authentification">
    <section class="contenu-authentification">
        <div class="contenu-authentification__inner">
            <h1>Contactez-nous</h1>

            <!-- =========================
                 MESSAGE DE SUCCÈS
                 ========================= -->
            <?php if (!empty($successMessage)): ?>
                <div class="message-authentification message-authentification--success" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>

            <!-- =========================
                 MESSAGE D’ERREUR
                 ========================= -->
            <?php if (!empty($errorMessage)): ?>
                <div class="message-authentification message-authentification--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <!-- =========================
                 FORMULAIRE DE CONTACT
                 ========================= -->
            <form class="formulaire-authentification" method="POST" action="index.php?page=contact">

                <!-- =========================
                     CHOIX DE CIVILITÉ
                     ========================= -->
                <fieldset class="formulaire-authentification__choices">
                    <legend class="visually-hidden">Civilité</legend>

                    <label class="formulaire-authentification__choice">
                        <span class="formulaire-authentification__choice-label">Mr</span>
                        <input
                            class="formulaire-authentification__checkbox"
                            type="radio"
                            name="civilite"
                            value="M"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'M') ? 'checked' : ''; ?>
                        >
                    </label>

                    <label class="formulaire-authentification__choice">
                        <span class="formulaire-authentification__choice-label">Mme</span>
                        <input
                            class="formulaire-authentification__checkbox"
                            type="radio"
                            name="civilite"
                            value="Mme"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'Mme') ? 'checked' : ''; ?>
                        >
                    </label>

                    <label class="formulaire-authentification__choice">
                        <span class="formulaire-authentification__choice-label">Autre</span>
                        <input
                            class="formulaire-authentification__checkbox"
                            type="radio"
                            name="civilite"
                            value="Autre"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'Autre') ? 'checked' : ''; ?>
                        >
                    </label>
                </fieldset>

                <!-- NOM -->
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

                <!-- PRÉNOM -->
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

                <!-- EMAIL -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="email">E-mail</label>
                    <input
                        class="formulaire-authentification__input"
                        type="email"
                        id="email"
                        name="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <!-- OBJET -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="objet">Objet du message</label>
                    <input
                        class="formulaire-authentification__input"
                        type="text"
                        id="objet"
                        name="objet"
                        required
                        value="<?php echo isset($_POST['objet']) ? htmlspecialchars($_POST['objet']) : ''; ?>"
                    >
                </div>

                <!-- MESSAGE -->
                <div class="formulaire-authentification__group">
                    <label class="formulaire-authentification__label" for="message">Message</label>
                    <textarea
                        class="formulaire-authentification__textarea"
                        id="message"
                        name="message"
                        required
                    ><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <!-- CONSENTEMENT -->
                <div class="formulaire-authentification__consent">
                    <input
                        class="formulaire-authentification__checkbox"
                        type="checkbox"
                        id="contact_consent"
                        name="contact_consent"
                        required
                        <?php echo isset($_POST['contact_consent']) ? 'checked' : ''; ?>
                    >
                    <label class="formulaire-authentification__consent-label" for="contact_consent">
                        J’accepte que mes données soient utilisées dans le cadre de ma demande, conformément à la
                        <a class="formulaire-authentification__link" href="index.php?page=politique-confidentialite">politique de confidentialité</a>.
                    </label>
                </div>

                <!-- BOUTON -->
                <div class="formulaire-authentification__submit">
                    <button class="formulaire-authentification__button" type="submit">Envoyer le message</button>
                </div>
            </form>

            <div class="separateur-authentification" aria-hidden="true"></div>

            <div class="informations-contact">
                <p>
                    Merci pour votre visite. Nous vous remercions d’avoir consulté notre site dédié au Fournier roux.
                </p>

                <p>
                    Si vous souhaitez partager votre avis, poser une question ou obtenir davantage d’informations sur les activités de l’association Fournier roux, nous serons ravis de vous lire. Vous pouvez nous contacter en remplissant le formulaire ci-dessus sur cette page.
                </p>

                <p>
                    Vous pouvez également nous écrire directement par e-mail à l’adresse suivante :
                    <strong>fournier_roux@contact.fr</strong>
                </p>

                <p>
                    Notre équipe vous répondra dans les meilleurs délais.
                </p>
            </div>
        </div>
    </section>
</main>