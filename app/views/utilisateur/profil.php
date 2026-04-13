<!-- =========================
     PAGE PROFIL
     Cette vue permet à l’utilisateur
     de consulter et modifier ses informations personnelles
     ainsi que de supprimer directement son compte
     ========================= -->

<main class="profile-page">
    <h1 class="profile-page__title">Mon profil</h1>

    <!-- =========================
         SECTION INFORMATIONS PERSONNELLES
         ========================= -->
    <section class="profile-page__section profile-page__section--info">
        <h2 class="profile-page__subtitle">Informations personnelles</h2>

        <!-- =========================
             MESSAGE D’ERREUR
             ========================= -->
        <?php if (!empty($erreur)): ?>
            <p class="profile-page__message profile-page__message--error">
                <?php echo htmlspecialchars($erreur); ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             MESSAGE DE SUCCÈS
             ========================= -->
        <?php if (!empty($succes)): ?>
            <p class="profile-page__message profile-page__message--success">
                <?php echo htmlspecialchars($succes); ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             FORMULAIRE DE MISE À JOUR DU PROFIL
             ========================= -->
        <form class="profile-form" method="POST" action="index.php?page=profil">
            <input
                type="hidden"
                name="csrf_token"
                value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
            >

            <div class="profile-form__group">
                <label class="profile-form__label" for="nom">Nom :</label>
                <input
                    class="profile-form__input"
                    type="text"
                    name="nom"
                    id="nom"
                    value="<?php echo htmlspecialchars($utilisateur['nom']); ?>"
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
                    value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>"
                    required
                >
            </div>

            <div class="profile-form__actions">
                <button class="profile-form__button" type="submit">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

        <!-- =========================
             DÉTAILS DU COMPTE
             ========================= -->
        <div class="profile-details">
            <p class="profile-details__item">
                <span class="profile-details__label">Email :</span>
                <span class="profile-details__value">
                    <?php echo htmlspecialchars($utilisateur['email']); ?>
                </span>
            </p>

            <p class="profile-details__item">
                <span class="profile-details__label">Rôle :</span>
                <span class="profile-details__value">
                    <?php echo $utilisateur['role'] === 'admin' ? 'Administrateur' : 'Utilisateur'; ?>
                </span>
            </p>
        </div>
    </section>

    <!-- =========================
         SECTION SUPPRESSION DU COMPTE
         Cette section n’est affichée
         que pour les utilisateurs non administrateurs
         ========================= -->
    <?php if ($utilisateur['role'] !== 'admin'): ?>
        <section class="profile-page__section profile-page__section--delete">
            <h2 class="profile-page__subtitle">Suppression du compte</h2>

            <p class="profile-delete-form__help">
                Vous pouvez supprimer définitivement votre compte depuis votre profil.
            </p>

            <form class="profile-delete-form" method="POST" action="index.php?page=profil">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                >

                <input
                    type="hidden"
                    name="action"
                    value="delete_account"
                >

                <div class="profile-delete-form__actions">
                    <button class="profile-delete-form__button" type="submit">
                        Supprimer mon compte
                    </button>
                </div>
            </form>
        </section>
    <?php endif; ?>
</main>