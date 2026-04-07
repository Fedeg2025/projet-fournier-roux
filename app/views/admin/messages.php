<section>
    <h3>Messages reçus</h3>

    <?php if (empty($messages)): ?>
        <p>Aucun message.</p>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <p>
                <strong><?php echo htmlspecialchars($message['objet']); ?></strong><br>
                <?php echo htmlspecialchars($message['prenom'] . ' ' . $message['nom']); ?> -
                <?php echo htmlspecialchars($message['email']); ?><br>
                <?php echo htmlspecialchars($message['message']); ?><br>
                <small><?php echo htmlspecialchars($message['date_envoi']); ?></small><br>

                <form method="POST" action="index.php?page=admin" style="display:inline;" onsubmit="return confirm('Supprimer ce message ?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="delete" value="<?php echo htmlspecialchars($message['id_message']); ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </p>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</section>