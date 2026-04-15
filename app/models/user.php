<?php

// =========================
// MODÈLE UTILISATEUR
// Ce fichier contient toutes les fonctions
// liées à la gestion des utilisateurs
// =========================


// =========================
// RECHERCHER UN UTILISATEUR PAR EMAIL
// =========================
function findUserByEmail($pdo, $email)
{
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    return $stmt->fetch();
}


// =========================
// CRÉER UN UTILISATEUR
// =========================
function createUser($pdo, $nom, $prenom, $email, $mot_de_passe, $role = 'utilisateur')
{
    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$nom, $prenom, $email, $hash, $role]);
}


// =========================
// RÉCUPÉRER TOUS LES UTILISATEURS
// =========================
function getAllUsers($pdo)
{
    $sql = "SELECT * FROM utilisateurs ORDER BY nom ASC";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}


// =========================
// METTRE À JOUR LE PROFIL UTILISATEUR
// =========================
function updateUserProfile($pdo, $id_utilisateur, $nom, $prenom)
{
    $sql = "UPDATE utilisateurs
            SET nom = ?, prenom = ?
            WHERE id_utilisateur = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$nom, $prenom, $id_utilisateur]);
}


// =========================
// SUPPRIMER LES MESSAGES DE L’UTILISATEUR
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