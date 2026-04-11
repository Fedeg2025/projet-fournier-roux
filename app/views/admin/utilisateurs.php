<section class="admin-users">
    <h2 class="admin-users__title">Utilisateurs</h2>

    <?php if (empty($utilisateurs)): ?>
        <p class="admin-users__empty">Aucun utilisateur.</p>
    <?php else: ?>
        <div class="admin-users__list">
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <article class="admin-users__item">
                    <h3 class="admin-users__name">
                        <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
                    </h3>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Email :</span>
                        <span class="admin-users__value">
                            <?php echo htmlspecialchars($utilisateur['email']); ?>
                        </span>
                    </p>

                    <p class="admin-users__info">
                        <span class="admin-users__label">Rôle :</span>
                        <span class="admin-users__value">
                            <?php
                            echo $utilisateur['role'] === 'admin'
                                ? 'Administrateur'
                                : 'Utilisateur';
                            ?>
                        </span>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>