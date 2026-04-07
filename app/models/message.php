<?php

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

function getAllMessages($pdo)
{
    $sql = "SELECT * FROM messages ORDER BY date_envoi DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function deleteMessage($pdo, $id_message)
{
    $sql = "DELETE FROM messages WHERE id_message = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_message]);
}