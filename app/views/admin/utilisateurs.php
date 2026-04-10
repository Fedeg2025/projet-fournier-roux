<section class="admin-users">
    <h3 class="admin-users__title">Utilisateurs</h3>

    <?php if (empty($utilisateurs)): ?>
        <p class="admin-users__empty">Aucun utilisateur.</p>
    <?php else: ?>
        <div class="admin-users__list">
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <article class="admin-users__item">
                    <h4 class="admin-users__name">
                        <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
                    </h4>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Email :</span>
                        <span class="admin-users__value">
                            <?php echo htmlspecialchars($utilisateur['email']); ?>
                        </span>
                    </p>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Rôle :</span>
                        <span class="admin-users__value">
                            <?php echo htmlspecialchars($utilisateur['role']); ?>
                        </span>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>