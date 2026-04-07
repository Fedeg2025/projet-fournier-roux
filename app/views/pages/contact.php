<main class="contact-page">
    <section class="contact-section">
        <div class="contact-section__inner">

            <div class="contact-card">
                <header class="contact-card__header">
                    <h2 class="contact-card__title">Contactez-nous</h2>
                </header>

                <?php if (!empty($succes)): ?>
                    <div class="contact-message contact-message--success" role="alert" aria-live="polite">
                        <?php echo htmlspecialchars($succes); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($erreur)): ?>
                    <div class="contact-message contact-message--error" role="alert" aria-live="polite">
                        <?php echo htmlspecialchars($erreur); ?>
                    </div>
                <?php endif; ?>

                <form class="contact-form" method="POST">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                    >

                    <fieldset class="contact-form__civility">
                        <legend class="contact-form__legend visually-hidden">Civilité</legend>

                        <label class="contact-form__radio-option">
                            <span class="contact-form__radio-text">Mr.</span>
                            <input
                                type="radio"
                                name="civilite"
                                value="M"
                                required
                                <?= (isset($_POST['civilite']) && $_POST['civilite'] === 'M') ? 'checked' : '' ?>
                            >
                        </label>

                        <label class="contact-form__radio-option">
                            <span class="contact-form__radio-text">Mme.</span>
                            <input
                                type="radio"
                                name="civilite"
                                value="Mme"
                                required
                                <?= (isset($_POST['civilite']) && $_POST['civilite'] === 'Mme') ? 'checked' : '' ?>
                            >
                        </label>

                        <label class="contact-form__radio-option">
                            <span class="contact-form__radio-text">Autres.</span>
                            <input
                                type="radio"
                                name="civilite"
                                value="Autre"
                                required
                                <?= (isset($_POST['civilite']) && $_POST['civilite'] === 'Autre') ? 'checked' : '' ?>
                            >
                        </label>
                    </fieldset>

                    <div class="contact-form__group">
                        <label class="contact-form__label" for="nom">Nom</label>
                        <input
                            class="contact-form__input"
                            type="text"
                            id="nom"
                            name="nom"
                            required
                            value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>"
                        >
                    </div>

                    <div class="contact-form__group">
                        <label class="contact-form__label" for="prenom">Prenom</label>
                        <input
                            class="contact-form__input"
                            type="text"
                            id="prenom"
                            name="prenom"
                            required
                            value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>"
                        >
                    </div>

                    <div class="contact-form__group">
                        <label class="contact-form__label" for="email">E-mail</label>
                        <input
                            class="contact-form__input"
                            type="email"
                            id="email"
                            name="email"
                            required
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                        >
                    </div>

                    <div class="contact-form__group">
                        <label class="contact-form__label" for="objet">Objet du message</label>
                        <textarea
                            class="contact-form__textarea contact-form__textarea--objet"
                            id="objet"
                            name="objet"
                            required
                        ><?= isset($_POST['objet']) ? htmlspecialchars($_POST['objet']) : '' ?></textarea>
                    </div>

                    <div class="contact-form__group">
                        <label class="contact-form__label" for="message">Message</label>
                        <textarea
                            class="contact-form__textarea"
                            id="message"
                            name="message"
                            required
                        ><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                    </div>

                    <div class="contact-form__submit">
                        <button class="contact-form__button" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>

            <div class="contact-info">
                <p>
                    merci pour votre visite, nous vous remercions d’avoir consulté notre site dédié au Fournier roux.
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