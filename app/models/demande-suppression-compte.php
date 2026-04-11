<?php

// Vérifie si un utilisateur a déjà une demande en attente
function hasPendingDeleteAccountRequest($pdo, $id_utilisateur)
{
    $sql = "SELECT COUNT(*)
            FROM demandes_suppression_compte
            WHERE id_utilisateur = ?
            AND statut = 'en_attente'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_utilisateur]);

    return (int) $stmt->fetchColumn() > 0;
}

// Crée une demande de suppression de compte
function createDeleteAccountRequest($pdo, $id_utilisateur, $motif = null)
{
    $sql_user = "SELECT nom, prenom, email
                 FROM utilisateurs
                 WHERE id_utilisateur = ?";

    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$id_utilisateur]);
    $utilisateur = $stmt_user->fetch();

    if (!$utilisateur) {
        return false;
    }

    $sql = "INSERT INTO demandes_suppression_compte
            (id_utilisateur, motif, nom_snapshot, prenom_snapshot, email_snapshot)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $id_utilisateur,
        $motif,
        $utilisateur['nom'],
        $utilisateur['prenom'],
        $utilisateur['email']
    ]);
}

// Récupère toutes les demandes de suppression
function getAllDeleteAccountRequests($pdo)
{
    $sql = "SELECT
                d.*,
                d.nom_snapshot AS nom,
                d.prenom_snapshot AS prenom,
                d.email_snapshot AS email,
                admin.nom AS admin_nom,
                admin.prenom AS admin_prenom
            FROM demandes_suppression_compte d
            LEFT JOIN utilisateurs admin ON d.traitee_par = admin.id_utilisateur
            ORDER BY d.date_demande DESC";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Marque une demande comme traitée
function markDeleteAccountRequestAsProcessed($pdo, $id_demande, $admin_id, $commentaire_admin = null)
{
    $sql = "UPDATE demandes_suppression_compte
            SET statut = 'traitee',
                date_traitement = NOW(),
                traitee_par = ?,
                commentaire_admin = ?
            WHERE id_demande = ?";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$admin_id, $commentaire_admin, $id_demande]);
}

// Marque une demande comme refusée
function markDeleteAccountRequestAsRefused($pdo, $id_demande, $admin_id, $commentaire_admin = null)
{
    $sql = "UPDATE demandes_suppression_compte
            SET statut = 'refusee',
                date_traitement = NOW(),
                traitee_par = ?,
                commentaire_admin = ?
            WHERE id_demande = ?";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$admin_id, $commentaire_admin, $id_demande]);
}