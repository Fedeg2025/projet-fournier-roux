<section class="admin-delete-requests">
    <h3 class="admin-delete-requests__title">Demandes de suppression de compte</h3>

    <?php if (empty($demandes_suppression)): ?>
        <p class="admin-delete-requests__empty">Aucune demande de suppression pour le moment.</p>
    <?php else: ?>
        <div class="admin-delete-requests__list">
            <?php foreach ($demandes_suppression as $demande): ?>
                <article class="admin-delete-requests__item">
                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Utilisateur :</span>
                        <span class="admin-delete-requests__value">
                            <?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom']) ?>
                        </span>
                    </p>

                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Email :</span>
                        <span class="admin-delete-requests__value">
                            <?= htmlspecialchars($demande['email']) ?>
                        </span>
                    </p>

                    <div class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Motif :</span>
                        <div class="admin-delete-requests__value">
                            <?= !empty($demande['motif']) ? nl2br(htmlspecialchars($demande['motif'])) : '—' ?>
                        </div>
                    </div>

                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Statut :</span>
                        <span class="admin-delete-requests__value">
                            <?php
                            if ($demande['statut'] === 'en_attente') {
                                echo 'En attente';
                            } elseif ($demande['statut'] === 'traitee') {
                                echo 'Traitée';
                            } elseif ($demande['statut'] === 'refusee') {
                                echo 'Refusée';
                            } else {
                                echo htmlspecialchars($demande['statut']);
                            }
                            ?>
                        </span>
                    </p>

                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Date de demande :</span>
                        <span class="admin-delete-requests__value">
                            <?= htmlspecialchars($demande['date_demande']) ?>
                        </span>
                    </p>

                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Date de traitement :</span>
                        <span class="admin-delete-requests__value">
                            <?= !empty($demande['date_traitement']) ? htmlspecialchars($demande['date_traitement']) : '—' ?>
                        </span>
                    </p>

                    <p class="admin-delete-requests__row">
                        <span class="admin-delete-requests__label">Traité par :</span>
                        <span class="admin-delete-requests__value">
                            <?php if (!empty($demande['admin_prenom']) || !empty($demande['admin_nom'])): ?>
                                <?= htmlspecialchars(trim(($demande['admin_prenom'] ?? '') . ' ' . ($demande['admin_nom'] ?? ''))) ?>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </p>

                    <div class="admin-delete-requests__actions">
                        <?php if (!empty($demande['statut']) && trim($demande['statut']) === 'en_attente'): ?>
                            <form
                                class="admin-delete-requests__form"
                                method="POST"
                                action="index.php?page=admin&section=utilisateurs"
                            >
                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                                >
                                <button
                                    class="admin-delete-requests__button admin-delete-requests__button--process"
                                    type="submit"
                                    name="process_delete_request"
                                    value="<?= (int) $demande['id_demande'] ?>"
                                >
                                    Traiter
                                </button>
                            </form>

                            <form
                                class="admin-delete-requests__form"
                                method="POST"
                                action="index.php?page=admin&section=utilisateurs"
                            >
                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                                >
                                <button
                                    class="admin-delete-requests__button admin-delete-requests__button--refuse"
                                    type="submit"
                                    name="refuse_delete_request"
                                    value="<?= (int) $demande['id_demande'] ?>"
                                >
                                    Refuser
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="admin-delete-requests__no-action">—</p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>