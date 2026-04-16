<?php

// =========================
// MODÈLE UTILISATEUR
// =========================


// =========================
// RECHERCHER UN UTILISATEUR PAR EMAIL
// =========================
function findUserByEmail($pdo, $email)
{
    try {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log('Erreur findUserByEmail : ' . $e->getMessage());
        return false;
    }
}


// =========================
// CRÉER UN UTILISATEUR
// =========================
function createUser($pdo, $nom, $prenom, $email, $mot_de_passe, $role = 'utilisateur')
{
    try {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$nom, $prenom, $email, $hash, $role]);
    } catch (PDOException $e) {
        error_log('Erreur createUser : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER TOUS LES UTILISATEURS
// =========================
function getAllUsers($pdo)
{
    try {
        $sql = "SELECT * FROM utilisateurs ORDER BY nom ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erreur getAllUsers : ' . $e->getMessage());
        return [];
    }
}


// =========================
// METTRE À JOUR LE PROFIL UTILISATEUR
// =========================
function updateUserProfile($pdo, $id_utilisateur, $nom, $prenom)
{
    try {
        $sql = "UPDATE utilisateurs
                SET nom = ?, prenom = ?
                WHERE id_utilisateur = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$nom, $prenom, $id_utilisateur]);
    } catch (PDOException $e) {
        error_log('Erreur updateUserProfile : ' . $e->getMessage());
        return false;
    }
}


// =========================
// SUPPRIMER LES MESSAGES DE L’UTILISATEUR
// =========================
function deleteUserMessages($pdo, $id_utilisateur)
{
    try {
        $sql = "DELETE FROM messages
                WHERE id_utilisateur = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$id_utilisateur]);
    } catch (PDOException $e) {
        error_log('Erreur deleteUserMessages : ' . $e->getMessage());
        return false;
    }
}


// =========================
// SUPPRIMER LE COMPTE UTILISATEUR
// =========================
function deleteUserAccount($pdo, $id_utilisateur)
{
    try {
        $sql = "DELETE FROM utilisateurs
                WHERE id_utilisateur = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$id_utilisateur]);
    } catch (PDOException $e) {
        error_log('Erreur deleteUserAccount : ' . $e->getMessage());
        return false;
    }
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