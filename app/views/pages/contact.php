<main class="auth-page contact-page">
    <section class="auth-content">
        <div class="auth-content__inner">

            <h1>Contactez-nous</h1>

            <?php if (!empty($succes)): ?>
                <div class="auth-message auth-message--success" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($erreur)): ?>
                <div class="auth-message auth-message--error" role="alert" aria-live="polite">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST" action="index.php?page=contact">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                >

                <fieldset class="auth-form__choices">
                    <legend class="visually-hidden">Civilité</legend>

                    <label class="auth-form__choice">
                        <span class="auth-form__choice-label">Mr.</span>
                        <input
                            class="auth-form__checkbox"
                            type="radio"
                            name="civilite"
                            value="M"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'M') ? 'checked' : ''; ?>
                        >
                    </label>

                    <label class="auth-form__choice">
                        <span class="auth-form__choice-label">Mme.</span>
                        <input
                            class="auth-form__checkbox"
                            type="radio"
                            name="civilite"
                            value="Mme"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'Mme') ? 'checked' : ''; ?>
                        >
                    </label>

                    <label class="auth-form__choice">
                        <span class="auth-form__choice-label">Autres.</span>
                        <input
                            class="auth-form__checkbox"
                            type="radio"
                            name="civilite"
                            value="Autre"
                            required
                            <?php echo (isset($_POST['civilite']) && $_POST['civilite'] === 'Autre') ? 'checked' : ''; ?>
                        >
                    </label>
                </fieldset>

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
                    <label class="auth-form__label" for="email">E-mail</label>
                    <input
                        class="auth-form__input"
                        type="email"
                        id="email"
                        name="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="objet">Objet du message</label>
                    <textarea
                        class="auth-form__textarea auth-form__textarea--objet"
                        id="objet"
                        name="objet"
                        required
                    ><?php echo isset($_POST['objet']) ? htmlspecialchars($_POST['objet']) : ''; ?></textarea>
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="message">Message</label>
                    <textarea
                        class="auth-form__textarea"
                        id="message"
                        name="message"
                        required
                    ><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <div class="auth-form__consent">
                    <input
                        class="auth-form__checkbox"
                        type="checkbox"
                        id="contact_consent"
                        name="contact_consent"
                        required
                        <?php echo isset($_POST['contact_consent']) ? 'checked' : ''; ?>
                    >
                    <label class="auth-form__consent-label" for="contact_consent">
                        J’accepte que mes données soient utilisées dans le cadre de ma demande, conformément à la
                        <a class="auth-form__link" href="index.php?page=politique-confidentialite">politique de confidentialité</a>.
                    </label>
                </div>

                <div class="auth-form__submit">
                    <button class="auth-form__button" type="submit">Envoyer le message</button>
                </div>
            </form>

            <div class="auth-divider" aria-hidden="true"></div>

            <div class="contact-info">
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