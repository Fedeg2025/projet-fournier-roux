<!-- =========================
     PAGE PROFIL
     Cette vue permet à l’utilisateur
     de consulter et modifier ses informations personnelles
     ainsi que de supprimer directement son compte
     ========================= -->

<main class="page-profil">
    <h1 class="page-profil__title">Mon profil</h1>

    <!-- =========================
         SECTION INFORMATIONS PERSONNELLES
         ========================= -->
    <section class="page-profil__section page-profil__section--infos">
        <h2 class="page-profil__subtitle">Informations personnelles</h2>

        <!-- =========================
             MESSAGE D’ERREUR
             ========================= -->
        <?php if (!empty($errorMessage)): ?>
            <p class="page-profil__message page-profil__message--error">
                <?php echo htmlspecialchars($errorMessage); ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             MESSAGE DE SUCCÈS
             ========================= -->
        <?php if (!empty($successMessage)): ?>
            <p class="page-profil__message page-profil__message--success">
                <?php echo htmlspecialchars($successMessage); ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             FORMULAIRE DE MISE À JOUR DU PROFIL
             ========================= -->
        <form class="formulaire-profil" method="POST" action="index.php?page=profil">
            <input
                type="hidden"
                name="csrf_token"
                value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
            >

            <div class="formulaire-profil__group">
                <label class="formulaire-profil__label" for="nom">Nom :</label>
                <input
                    class="formulaire-profil__input"
                    type="text"
                    name="nom"
                    id="nom"
                    value="<?php echo htmlspecialchars($user['nom']); ?>"
                    required
                >
            </div>

            <div class="formulaire-profil__group">
                <label class="formulaire-profil__label" for="prenom">Prénom :</label>
                <input
                    class="formulaire-profil__input"
                    type="text"
                    name="prenom"
                    id="prenom"
                    value="<?php echo htmlspecialchars($user['prenom']); ?>"
                    required
                >
            </div>

            <div class="formulaire-profil__actions">
                <button class="formulaire-profil__button" type="submit">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

        <!-- =========================
             DÉTAILS DU COMPTE
             ========================= -->
        <div class="details-profil">
            <p class="details-profil__item">
                <span class="details-profil__label">Email :</span>
                <span class="details-profil__value">
                    <?php echo htmlspecialchars($user['email']); ?>
                </span>
            </p>

            <p class="details-profil__item">
                <span class="details-profil__label">Rôle :</span>
                <span class="details-profil__value">
                    <?php echo $user['role'] === 'admin' ? 'Administrateur' : 'Utilisateur'; ?>
                </span>
            </p>
        </div>
    </section>

    <!-- =========================
         SECTION SUPPRESSION DU COMPTE
         Cette section n’est affichée
         que pour les utilisateurs non administrateurs
         ========================= -->
    <?php if ($user['role'] !== 'admin'): ?>
        <section class="page-profil__section page-profil__section--suppression">
            <h2 class="page-profil__subtitle">Suppression du compte</h2>

            <p class="formulaire-suppression-profil__help">
                Vous pouvez supprimer définitivement votre compte depuis votre profil.
            </p>

            <form class="formulaire-suppression-profil" method="POST" action="index.php?page=profil">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                >

                <input
                    type="hidden"
                    name="action"
                    value="delete_account"
                >

                <div class="formulaire-suppression-profil__actions">
                    <button class="formulaire-suppression-profil__button" type="submit">
                        Supprimer mon compte
                    </button>
                </div>
            </form>
        </section>
    <?php endif; ?>
</main>