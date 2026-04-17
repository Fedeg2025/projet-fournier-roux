<!-- =========================
     LISTE DES UTILISATEURS
     Cette vue permet à l’administrateur
     de consulter les utilisateurs enregistrés sur le site
     ========================= -->

<section class="utilisateurs-admin">
    <h2 class="utilisateurs-admin__title">Utilisateurs</h2>

    <!-- =========================
         CAS AUCUN UTILISATEUR
         ========================= -->
    <?php if (empty($users)): ?>
        <p class="utilisateurs-admin__empty">Aucun utilisateur.</p>

    <?php else: ?>

        <!-- =========================
             LISTE DES UTILISATEURS
             ========================= -->
        <div class="utilisateurs-admin__list">
            <?php foreach ($users as $user): ?>
                <article class="utilisateurs-admin__item">
                    <h3 class="utilisateurs-admin__name">
                        <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
                    </h3>

                    <p class="utilisateurs-admin__info">
                        <span class="utilisateurs-admin__label">Email :</span>
                        <span class="utilisateurs-admin__value">
                            <?php echo htmlspecialchars($user['email']); ?>
                        </span>
                    </p>

                    <p class="utilisateurs-admin__info">
                        <span class="utilisateurs-admin__label">Rôle :</span>
                        <span class="utilisateurs-admin__value">
                            <?php echo $user['role'] === 'admin' ? 'Administrateur' : 'Utilisateur'; ?>
                        </span>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>