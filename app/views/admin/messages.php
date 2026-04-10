<section class="admin-messages">
    <h3 class="admin-messages__title">Messages reçus</h3>

    <?php if (empty($messages)): ?>
        <p class="admin-messages__empty">Aucun message.</p>
    <?php else: ?>
        <div class="admin-messages__list">
            <?php foreach ($messages as $message): ?>
                <article class="admin-messages__item">
                    <h4 class="admin-messages__subject">
                        <?php echo htmlspecialchars($message['objet']); ?>
                    </h4>

                    <p class="admin-messages__meta">
                        <span class="admin-messages__author">
                            <?php echo htmlspecialchars($message['prenom'] . ' ' . $message['nom']); ?>
                        </span>
                        <br>
                        <span class="admin-messages__email">
                            <?php echo htmlspecialchars($message['email']); ?>
                        </span>
                    </p>

                    <p class="admin-messages__text">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </p>

                    <p class="admin-messages__date">
                        <small><?php echo htmlspecialchars($message['date_envoi']); ?></small>
                    </p>

                    <form
                        class="admin-messages__form"
                        method="POST"
                        action="index.php?page=admin&section=messages"
                        onsubmit="return confirm('Supprimer ce message ?');"
                    >
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                        >

                        <input
                            type="hidden"
                            name="delete"
                            value="<?php echo htmlspecialchars($message['id_message']); ?>"
                        >

                        <button type="submit" class="admin-messages__button">
                            Supprimer
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>