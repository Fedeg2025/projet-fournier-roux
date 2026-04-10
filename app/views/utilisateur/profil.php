<main class="profile-page">
    <section class="profile-page__section profile-page__section--info">
        <h2 class="profile-page__title">Mon profil</h2>

        <?php if (!empty($erreur)): ?>
            <p class="profile-page__message profile-page__message--error">
                <?= htmlspecialchars($erreur) ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($succes)): ?>
            <p class="profile-page__message profile-page__message--success">
                <?= htmlspecialchars($succes) ?>
            </p>
        <?php endif; ?>

        <form class="profile-form" method="POST" action="index.php?page=profil">
            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
            >

            <div class="profile-form__group">
                <label class="profile-form__label" for="nom">Nom :</label>
                <input
                    class="profile-form__input"
                    type="text"
                    name="nom"
                    id="nom"
                    value="<?= htmlspecialchars($utilisateur['nom']) ?>"
                    required
                >
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="prenom">Prénom :</label>
                <input
                    class="profile-form__input"
                    type="text"
                    name="prenom"
                    id="prenom"
                    value="<?= htmlspecialchars($utilisateur['prenom']) ?>"
                    required
                >
            </div>

            <div class="profile-form__actions">
                <button class="profile-form__button" type="submit">Modifier</button>
            </div>
        </form>

        <div class="profile-details">
            <p class="profile-details__item">
                <span class="profile-details__label">Email :</span>
                <span class="profile-details__value"><?= htmlspecialchars($utilisateur['email']) ?></span>
            </p>

            <p class="profile-details__item">
                <span class="profile-details__label">Rôle :</span>
                <span class="profile-details__value"><?= htmlspecialchars($utilisateur['role']) ?></span>
            </p>
        </div>
    </section>

    <section class="profile-page__section profile-page__section--delete">
        <h3 class="profile-page__subtitle">Suppression du compte</h3>

        <form class="profile-delete-form" method="POST" action="index.php?page=profil">
            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
            >
            <input
                type="hidden"
                name="action"
                value="delete_account_request"
            >

            <div class="profile-delete-form__group">
                <label class="profile-delete-form__label" for="motif">Motif (optionnel) :</label>
                <textarea
                    class="profile-delete-form__textarea"
                    name="motif"
                    id="motif"
                    rows="5"
                ></textarea>
            </div>

            <div class="profile-delete-form__actions">
                <button class="profile-delete-form__button" type="submit">
                    Demander la suppression du compte
                </button>
            </div>
        </form>
    </section>
</main>