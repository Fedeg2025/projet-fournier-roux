<?php

// Chargement du modèle permettant de gérer
// les messages envoyés via le formulaire de contact.
require_once __DIR__ . '/../models/message.php';

// Vérifie que la session est démarrée.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Génère un jeton CSRF s'il n'existe pas encore.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialisation des variables de retour
// utilisées pour afficher un message de succès ou d'erreur.
$succes = '';
$erreur = '';

/**
 * ---------------------------------------------------------
 * TRAITEMENT DU FORMULAIRE DE CONTACT
 * ---------------------------------------------------------
 * Cette section vérifie si le formulaire a été soumis
 * puis traite les données envoyées par l'utilisateur.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification CSRF.
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreur = 'Requête invalide (CSRF).';
    } else {
        // Nettoyage des données saisies dans le formulaire.
        $civilite = trim($_POST['civilite'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $objet = trim($_POST['objet'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Par défaut, aucun utilisateur n'est associé au message.
        $id_utilisateur = null;

        // Si un utilisateur est connecté, on récupère son identifiant
        // afin de l'associer au message envoyé.
        if (isset($_SESSION['user'])) {
            $id_utilisateur = $_SESSION['user']['id_utilisateur'];
        }

        // Vérifie que tous les champs obligatoires ont été remplis.
        if (empty($civilite) || empty($prenom) || empty($nom) || empty($email) || empty($objet) || empty($message)) {
            $erreur = 'Tous les champs sont obligatoires.';
        } elseif (!in_array($civilite, ['M', 'Mme', 'Autre'], true)) {
            $erreur = 'La civilité est invalide.';
        } elseif (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 100) {
            $erreur = 'Le prénom doit contenir entre 2 et 100 caractères.';
        } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 100) {
            $erreur = 'Le nom doit contenir entre 2 et 100 caractères.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur = 'Email invalide.';
        } elseif (strlen($email) > 255) {
            $erreur = "L'email est trop long.";
        } elseif (mb_strlen($objet) < 3 || mb_strlen($objet) > 150) {
            $erreur = "L'objet doit contenir entre 3 et 150 caractères.";
        } elseif (mb_strlen($message) < 10) {
            $erreur = 'Le message doit contenir au moins 10 caractères.';
        } else {
            // Enregistrement du message dans la base de données.
            createMessage(
                $pdo,
                $civilite,
                $prenom,
                $nom,
                $email,
                $objet,
                $message,
                $id_utilisateur
            );

            // Message de confirmation en cas de succès.
            $succes = 'Message envoyé avec succès.';

            // Régénération du jeton CSRF après succès.
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

/**
 * ---------------------------------------------------------
 * AFFICHAGE DE LA PAGE
 * ---------------------------------------------------------
 * Chargement des différentes vues composant
 * la page de contact.
 */
require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/pages/contact.php';
require_once __DIR__ . '/../views/pages/footer.php';