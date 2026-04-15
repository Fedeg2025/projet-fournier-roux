<!-- =========================
     LISTE DES MESSAGES REÇUS
     Cette vue permet à l’administrateur
     de consulter et supprimer les messages envoyés via le formulaire de contact
     ========================= -->

<section class="messages-admin">
    <h2 class="messages-admin__title">Messages reçus</h2>

    <!-- =========================
         CAS AUCUN MESSAGE
         ========================= -->
    <?php if (empty($messages)): ?>
        <p class="messages-admin__empty">Aucun message.</p>

    <?php else: ?>

        <!-- =========================
             LISTE DES MESSAGES
             ========================= -->
        <div class="messages-admin__list">
            <?php foreach ($messages as $messageItem): ?>
                <article class="messages-admin__item">

                    <!-- =========================
                         OBJET DU MESSAGE
                         ========================= -->
                    <h3 class="messages-admin__subject">
                        <?php echo htmlspecialchars($messageItem['objet']); ?>
                    </h3>

                    <!-- =========================
                         INFORMATIONS EXPÉDITEUR
                         ========================= -->
                    <p class="messages-admin__meta">
                        <span class="messages-admin__author">
                            <?php echo htmlspecialchars($messageItem['prenom'] . ' ' . $messageItem['nom']); ?>
                        </span>
                        <br>
                        <span class="messages-admin__email">
                            <?php echo htmlspecialchars($messageItem['email']); ?>
                        </span>
                    </p>

                    <!-- =========================
                         CONTENU DU MESSAGE
                         ========================= -->
                    <p class="messages-admin__text">
                        <?php echo nl2br(htmlspecialchars($messageItem['message'])); ?>
                    </p>

                    <!-- =========================
                         DATE D’ENVOI
                         ========================= -->
                    <p class="messages-admin__date">
                        <small><?php echo htmlspecialchars($messageItem['date_envoi']); ?></small>
                    </p>

                    <!-- =========================
                         ACTION SUPPRESSION
                         Suppression directe en POST
                         avec confirmation JavaScript
                         ========================= -->
                    <div class="messages-admin__actions">
                        <form
                            class="messages-admin__confirm-form"
                            method="POST"
                            action="index.php?page=admin&section=messages"
                            onsubmit="return confirm('Confirmer la suppression de ce message ?');"
                        >
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
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