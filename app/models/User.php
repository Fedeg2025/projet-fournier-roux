<?php

// =========================
// MODÈLE UTILISATEUR
// Ce fichier contient les fonctions
// liées à la gestion des utilisateurs
// =========================


// =========================
// RECHERCHER UN UTILISATEUR PAR EMAIL
// Cette fonction permet de retrouver
// un utilisateur à partir de son adresse email
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
// Cette fonction enregistre un nouvel utilisateur
// avec un mot de passe hashé
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
// Cette fonction retourne la liste complète
// des utilisateurs triés par nom
// =========================
function getAllUsers($pdo)
{
    $sql = "SELECT * FROM utilisateurs ORDER BY nom ASC";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}


// =========================
// ANONYMISER UN UTILISATEUR
// Cette fonction remplace les données personnelles
// dans le cadre d’une suppression ou d’une anonymisation
// =========================
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