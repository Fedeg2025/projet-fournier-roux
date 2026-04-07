<?php

function hasPendingDeleteAccountRequest($pdo, $idUtilisateur)
{
    $sql = "SELECT COUNT(*) 
            FROM demandes_suppression_compte 
            WHERE id_utilisateur = ? 
            AND statut = 'en_attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idUtilisateur]);

    return (int) $stmt->fetchColumn() > 0;
}

function createDeleteAccountRequest($pdo, $idUtilisateur, $motif = null)
{
    $stmtUser = $pdo->prepare("SELECT nom, prenom, email FROM utilisateurs WHERE id_utilisateur = ?");
    $stmtUser->execute([$idUtilisateur]);
    $user = $stmtUser->fetch();

    if (!$user) {
        return false;
    }

    $sql = "INSERT INTO demandes_suppression_compte 
            (id_utilisateur, motif, nom_snapshot, prenom_snapshot, email_snapshot)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $idUtilisateur,
        $motif,
        $user['nom'],
        $user['prenom'],
        $user['email']
    ]);
}

function getAllDeleteAccountRequests($pdo)
{
    $sql = "SELECT 
                d.*,
                COALESCE(d.nom_snapshot, u.nom) AS nom,
                COALESCE(d.prenom_snapshot, u.prenom) AS prenom,
                COALESCE(d.email_snapshot, u.email) AS email,
                admin.nom AS admin_nom,
                admin.prenom AS admin_prenom
            FROM demandes_suppression_compte d
            LEFT JOIN utilisateurs u ON d.id_utilisateur = u.id_utilisateur
            LEFT JOIN utilisateurs admin ON d.traitee_par = admin.id_utilisateur
            ORDER BY d.date_demande DESC";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function markDeleteAccountRequestAsProcessed($pdo, $idDemande, $adminId, $commentaireAdmin = null)
{
    $sql = "UPDATE demandes_suppression_compte
            SET statut = 'traitee',
                date_traitement = NOW(),
                traitee_par = ?,
                commentaire_admin = ?
            WHERE id_demande = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$adminId, $commentaireAdmin, $idDemande]);
}

function markDeleteAccountRequestAsRefused($pdo, $idDemande, $adminId, $commentaireAdmin = null)
{
    $sql = "UPDATE demandes_suppression_compte
            SET statut = 'refusee',
                date_traitement = NOW(),
                traitee_par = ?,
                commentaire_admin = ?
            WHERE id_demande = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$adminId, $commentaireAdmin, $idDemande]);
}