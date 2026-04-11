<!-- =========================
     LISTE DES MESSAGES REÇUS
     Cette vue permet à l’administrateur
     de consulter et supprimer les messages envoyés via le formulaire de contact
     ========================= -->

<section class="admin-messages">
    <h2 class="admin-messages__title">Messages reçus</h2>

    <!-- =========================
         CAS AUCUN MESSAGE
         ========================= -->
    <?php if (empty($messages)): ?>
        <p class="admin-messages__empty">Aucun message.</p>

    <?php else: ?>

        <!-- =========================
             LISTE DES MESSAGES
             ========================= -->
        <div class="admin-messages__list">
            <?php foreach ($messages as $message): ?>
                <article class="admin-messages__item">

                    <!-- =========================
                         OBJET DU MESSAGE
                         ========================= -->
                    <h3 class="admin-messages__subject">
                        <?php echo htmlspecialchars($message['objet']); ?>
                    </h3>

                    <!-- =========================
                         INFORMATIONS EXPÉDITEUR
                         ========================= -->
                    <p class="admin-messages__meta">
                        <span class="admin-messages__author">
                            <?php echo htmlspecialchars($message['prenom'] . ' ' . $message['nom']); ?>
                        </span>
                        <br>
                        <span class="admin-messages__email">
                            <?php echo htmlspecialchars($message['email']); ?>
                        </span>
                    </p>

                    <!-- =========================
                         CONTENU DU MESSAGE
                         ========================= -->
                    <p class="admin-messages__text">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </p>

                    <!-- =========================
                         DATE D’ENVOI
                         ========================= -->
                    <p class="admin-messages__date">
                        <small><?php echo htmlspecialchars($message['date_envoi']); ?></small>
                    </p>

                    <!-- =========================
                         ACTIONS
                         ========================= -->
                    <div class="admin-messages__actions">
                        <a
                            class="admin-messages__delete-link"
                            href="index.php?page=admin&section=messages&confirm_delete_message=<?php echo htmlspecialchars($message['id_message']); ?>"
                        >
                            Supprimer
                        </a>
                    </div>

                    <!-- =========================
                         CONFIRMATION DE SUPPRESSION
                         ========================= -->
                    <?php if (isset($confirm_delete_message) && $confirm_delete_message === (int) $message['id_message']): ?>
                        <div class="admin-messages__confirm">
                            <p class="admin-messages__confirm-text">
                                Confirmer la suppression de ce message ?
                            </p>

                            <form
                                class="admin-messages__confirm-form"
                                method="POST"
                                action="index.php?page=admin&section=messages"
                            >
                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                                >

                                <input
                                    type="hidden"
                                    name="delete"
                                    value="<?php echo htmlspecialchars($message['id_message']); ?>"
                                >

                                <button
                                    class="admin-messages__button admin-messages__button--danger"
                                    type="submit"
                                >
                                    Oui, supprimer
                                </button>

                                <a
                                    class="admin-messages__button admin-messages__button--secondary"
                                    href="index.php?page=admin&section=messages"
                                >
                                    Annuler
                                </a>
                            </form>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>