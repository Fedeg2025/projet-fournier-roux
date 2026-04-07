<section>
    <h3>Utilisateurs</h3>

    <?php if (empty($utilisateurs)): ?>
        <p>Aucun utilisateur.</p>
    <?php else: ?>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <p>
                <strong>
                    <?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>
                </strong><br>

                Email : <?php echo htmlspecialchars($utilisateur['email']); ?><br>
                Rôle : <?php echo htmlspecialchars($utilisateur['role']); ?>
            </p>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</section>