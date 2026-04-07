<main>
    <h2>Mon profil</h2>

    <?php if (!empty($erreur)): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <?php if (!empty($succes)): ?>
        <p style="color:green;"><?= htmlspecialchars($succes) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=profil">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']) ?>" required>

        <button type="submit">Modifier</button>
    </form>

    <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email']) ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($utilisateur['role']) ?></p>

    <hr>

    <h3>Suppression du compte</h3>

    <form method="POST" action="index.php?page=profil">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="hidden" name="action" value="delete_account_request">

        <label>Motif (optionnel) :</label>
        <textarea name="motif"></textarea>

        <button type="submit">Demander la suppression du compte</button>
    </form>
</main>