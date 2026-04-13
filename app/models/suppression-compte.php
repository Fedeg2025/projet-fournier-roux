<?php

// =========================
// MODÈLE SUPPRESSION DE COMPTE
// Ce fichier contient les fonctions liées
// à la suppression directe du compte utilisateur
// =========================


// =========================
// SUPPRIMER LES MESSAGES DE L’UTILISATEUR
// Cette fonction supprime les messages liés
// à l’utilisateur avant la suppression du compte
// =========================
function deleteUserMessages($pdo, $id_utilisateur)
{
    $sql = "DELETE FROM messages
            WHERE id_utilisateur = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_utilisateur]);
}


// =========================
// SUPPRIMER LE COMPTE UTILISATEUR
// Cette fonction supprime le compte
// dans la table utilisateurs
// =========================
function deleteUserAccount($pdo, $id_utilisateur)
{
    $sql = "DELETE FROM utilisateurs
            WHERE id_utilisateur = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_utilisateur]);
}


// =========================
// SUPPRIMER LE COMPTE ET LES DONNÉES ASSOCIÉES
// Cette fonction supprime d’abord les messages,
// puis le compte utilisateur, dans une transaction
// =========================
function deleteAccountWithRelatedData($pdo, $id_utilisateur)
{
    try {
        $pdo->beginTransaction();

        deleteUserMessages($pdo, $id_utilisateur);
        deleteUserAccount($pdo, $id_utilisateur);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        return false;
    }
}