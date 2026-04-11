<?php

// =========================
// UTILISATEURS
// =========================

// Trouver un utilisateur par email
function findUserByEmail($pdo, $email)
{
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch();
}

// Créer un utilisateur
function createUser($pdo, $nom, $prenom, $email, $mot_de_passe, $role = 'utilisateur')
{
    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom, $prenom, $email, $hash, $role]);
}

// Récupérer tous les utilisateurs
function getAllUsers($pdo)
{
    $sql = "SELECT * FROM utilisateurs ORDER BY nom ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Anonymiser un utilisateur (RGPD)
function anonymiseUser($pdo, $id_utilisateur)
{
    $email_anonyme = 'anonyme_' . $id_utilisateur . '@example.com';
    $mot_de_passe_invalide = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

    $sql = "UPDATE utilisateurs
            SET nom = 'Anonyme',
                prenom = 'Utilisateur',
                email = ?,
                mot_de_passe = ?
            WHERE id_utilisateur = ?";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$email_anonyme, $mot_de_passe_invalide, $id_utilisateur]);
}