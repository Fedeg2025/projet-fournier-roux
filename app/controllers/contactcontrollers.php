<?php

// =========================
// MODÈLE MESSAGE
// =========================
require_once BASE_PATH . '/app/models/message.php';

// =========================
// VARIABLES
// =========================
$succes = '';
$erreur = '';

// =========================
// TRAITEMENT DU FORMULAIRE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreur = 'Requête invalide (CSRF).';
    } else {
        $civilite = trim($_POST['civilite'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $objet = trim($_POST['objet'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $contact_consent = $_POST['contact_consent'] ?? '';

        $id_utilisateur = null;

        if (isset($_SESSION['user'])) {
            $id_utilisateur = $_SESSION['user']['id_utilisateur'];
        }

        if (empty($civilite) || empty($prenom) || empty($nom) || empty($email) || empty($objet) || empty($message)) {
            $erreur = 'Tous les champs sont obligatoires.';
        } elseif (empty($contact_consent)) {
            $erreur = 'Vous devez accepter la politique de confidentialité.';
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

            $succes = 'Message envoyé avec succès.';
        }
    }
}

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/pages/contact.php';
require_once BASE_PATH . '/app/views/pages/footer.php';