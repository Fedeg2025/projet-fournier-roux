<?php

// =========================
// MODÈLE MESSAGE
// Ce fichier contient les fonctions
// liées aux messages envoyés via
// le formulaire de contact
// =========================


// =========================
// CRÉER UN MESSAGE
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
// =========================
function getAllMessages($pdo)
{
    try {
        $sql = "SELECT * FROM messages ORDER BY date_envoi DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erreur getAllMessages : ' . $e->getMessage());
        return [];
    }
}


// =========================
// SUPPRIMER UN MESSAGE
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