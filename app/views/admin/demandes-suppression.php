<section>
    <h3>Demandes de suppression de compte</h3>

    <?php if (empty($demandes_suppression)): ?>
        <p>Aucune demande de suppression pour le moment.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Date de demande</th>
                    <th>Date de traitement</th>
                    <th>Traité par</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes_suppression as $demande): ?>
                    <tr>
                        <td><?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom']) ?></td>
                        <td><?= htmlspecialchars($demande['email']) ?></td>
                        <td><?= !empty($demande['motif']) ? nl2br(htmlspecialchars($demande['motif'])) : '—' ?></td>
                        <td>
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
                        </td>
                        <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                        <td><?= !empty($demande['date_traitement']) ? htmlspecialchars($demande['date_traitement']) : '—' ?></td>
                        <td>
                            <?php if (!empty($demande['admin_prenom']) || !empty($demande['admin_nom'])): ?>
                                <?= htmlspecialchars(trim(($demande['admin_prenom'] ?? '') . ' ' . ($demande['admin_nom'] ?? ''))) ?>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($demande['statut']) && trim($demande['statut']) === 'en_attente'): ?>
                                <form method="POST" action="index.php?page=admin" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <button type="submit" name="process_delete_request" value="<?= (int) $demande['id_demande'] ?>">Traiter</button>
                                </form>

                                <form method="POST" action="index.php?page=admin" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <button type="submit" name="refuse_delete_request" value="<?= (int) $demande['id_demande'] ?>">Refuser</button>
                                </form>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>