<?php

// =========================
// MODÈLE MESSAGE
// Ce fichier contient les fonctions
// liées aux messages envoyés via
// le formulaire de contact
// =========================


// =========================
// CRÉER UN MESSAGE
// Cette fonction enregistre un message
// envoyé par un utilisateur ou un visiteur
// Paramètres :
// - $pdo : connexion à la base de données
// - $title : civilité du contact
// - $firstName : prénom du contact
// - $lastName : nom du contact
// - $email : email du contact
// - $subject : objet du message
// - $message : contenu du message
// - $userId : identifiant utilisateur optionnel
// Retour : true si l’enregistrement réussit, sinon false
// =========================
function createMessage($pdo, $title, $firstName, $lastName, $email, $subject, $message, $userId = null)
{
    try {
        $sql = "INSERT INTO messages (civilite, prenom, nom, email, objet, message, id_utilisateur)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            $title,
            $firstName,
            $lastName,
            $email,
            $subject,
            $message,
            $userId
        ]);
    } catch (PDOException $e) {
        error_log('Erreur createMessage : ' . $e->getMessage());
        return false;
    }
}


// =========================
// RÉCUPÉRER TOUS LES MESSAGES
// Cette fonction retourne la liste
// des messages triés par date d’envoi
// du plus récent au plus ancien
// Paramètre :
// - $pdo : connexion à la base de données
// Retour : tableau des messages ou tableau vide si erreur
// =========================
function getAllMessages($pdo)
{
    try {
        $sql = "SELECT * FROM messages ORDER BY date_envoi DESC";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erreur getAllMessages : ' . $e->getMessage());
        return [];
    }
}


// =========================
// SUPPRIMER UN MESSAGE
// Cette fonction permet de supprimer
// un message depuis l’interface d’administration
// Paramètres :
// - $pdo : connexion à la base de données
// - $messageId : identifiant du message
// Retour : true si la suppression réussit, sinon false
// =========================
function deleteMessage($pdo, $messageId)
{
    try {
        $sql = "DELETE FROM messages WHERE id_message = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([(int) $messageId]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log('Erreur deleteMessage : ' . $e->getMessage());
        return false;
    }
}