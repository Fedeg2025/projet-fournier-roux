<section class="messages-admin">
    <h2 class="messages-admin__title">Messages reçus</h2>

    <?php if (empty($messages)): ?>
        <p class="messages-admin__empty">Aucun message.</p>

    <?php else: ?>

        <div class="messages-admin__list">
            <?php foreach ($messages as $messageItem): ?>
                <article class="messages-admin__item">

                    <h3 class="messages-admin__subject">
                        <?php echo htmlspecialchars($messageItem['objet']); ?>
                    </h3>

                    <p class="messages-admin__meta">
                        <span class="messages-admin__author">
                            <?php echo htmlspecialchars($messageItem['prenom'] . ' ' . $messageItem['nom']); ?>
                        </span>
                        <br>
                        <span class="messages-admin__email">
                            <?php echo htmlspecialchars($messageItem['email']); ?>
                        </span>
                    </p>

                    <p class="messages-admin__text">
                        <?php echo nl2br(htmlspecialchars($messageItem['message'])); ?>
                    </p>

                    <p class="messages-admin__date">
                        <small><?php echo htmlspecialchars($messageItem['date_envoi']); ?></small>
                    </p>

                    <div class="messages-admin__actions">
                        <form
                            class="messages-admin__confirm-form"
                            method="POST"
                            action="index.php?page=admin&section=messages"
                            onsubmit="return confirm('Confirmer la suppression de ce message ?');"
                        >

                            <button
                                class="messages-admin__button messages-admin__button--danger"
                                type="submit"
                                name="delete"
                                value="<?php echo (int) $messageItem['id_message']; ?>"
                            >
                                Supprimer
                            </button>
                        </form>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>