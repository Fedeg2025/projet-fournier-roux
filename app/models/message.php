<?php

// =========================
// MODÈLE MESSAGE
// Ce fichier contient les fonctions
// liées aux messages envoyés via le formulaire de contact
// =========================


// =========================
// CRÉER UN MESSAGE
// Cette fonction enregistre un message
// envoyé par un utilisateur ou un visiteur
// =========================
function createMessage($pdo, $civilite, $prenom, $nom, $email, $objet, $message, $id_utilisateur = null)
{
    $sql = "INSERT INTO messages (civilite, prenom, nom, email, objet, message, id_utilisateur)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $civilite,
        $prenom,
        $nom,
        $email,
        $objet,
        $message,
        $id_utilisateur
    ]);
}


// =========================
// RÉCUPÉRER TOUS LES MESSAGES
// Cette fonction retourne la liste des messages
// triés par date d’envoi (du plus récent au plus ancien)
// =========================
function getAllMessages($pdo)
{
    $sql = "SELECT * FROM messages ORDER BY date_envoi DESC";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}


// =========================
// SUPPRIMER UN MESSAGE
// Cette fonction permet de supprimer un message
// depuis l’interface d’administration
// =========================
function deleteMessage($pdo, $id_message)
{
    $sql = "DELETE FROM messages WHERE id_message = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$id_message]);
}