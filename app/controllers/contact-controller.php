<?php

// =========================
// MODÈLE MESSAGE
// =========================
require_once BASE_PATH . '/app/models/message.php';


// =========================
// AFFICHAGE DE LA PAGE CONTACT
// =========================
function renderContactPage($successMessage = '', $errorMessage = '')
{
    require BASE_PATH . '/app/views/layouts/header.php';
    require BASE_PATH . '/app/views/pages/contact.php';
    require BASE_PATH . '/app/views/layouts/footer.php';
    exit;
}


// =========================
// AFFICHAGE DE LA PAGE CONTACT
// =========================
function showContact()
{
    $successMessage = $_SESSION['flash_success'] ?? '';
    $errorMessage = $_SESSION['flash_error'] ?? '';

    unset($_SESSION['flash_success'], $_SESSION['flash_error']);

    renderContactPage($successMessage, $errorMessage);
}


// =========================
// TRAITEMENT DU FORMULAIRE DE CONTACT
// =========================
function processContact()
{
    global $pdo;

    $successMessage = '';
    $errorMessage = '';

    $title = trim($_POST['civilite'] ?? '');
    $firstName = trim($_POST['prenom'] ?? '');
    $lastName = trim($_POST['nom'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $subject = trim($_POST['objet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $contactConsent = $_POST['contact_consent'] ?? '';

    $userId = null;

    if (isset($_SESSION['user'])) {
        $userId = $_SESSION['user']['id_utilisateur'];
    }

    if (
        empty($title) ||
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($subject) ||
        empty($message)
    ) {
        $errorMessage = 'Tous les champs sont obligatoires.';
    } elseif (empty($contactConsent)) {
        $errorMessage = 'Vous devez accepter la politique de confidentialité.';
    } elseif (!in_array($title, ['M', 'Mme', 'Autre'], true)) {
        $errorMessage = 'La civilité est invalide.';
    } elseif (mb_strlen($firstName) < 2 || mb_strlen($firstName) > 100) {
        $errorMessage = 'Le prénom doit contenir entre 2 et 100 caractères.';
    } elseif (mb_strlen($lastName) < 2 || mb_strlen($lastName) > 100) {
        $errorMessage = 'Le nom doit contenir entre 2 et 100 caractères.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Email invalide.';
    } elseif (strlen($email) > 255) {
        $errorMessage = "L'email est trop long.";
    } elseif (mb_strlen($subject) < 3 || mb_strlen($subject) > 150) {
        $errorMessage = "L'objet doit contenir entre 3 et 150 caractères.";
    } elseif (mb_strlen($message) < 10) {
        $errorMessage = 'Le message doit contenir au moins 10 caractères.';
    } else {
        $messageCreated = createMessage(
            $pdo,
            $title,
            $firstName,
            $lastName,
            $email,
            $subject,
            $message,
            $userId
        );

        if ($messageCreated) {
            $_SESSION['flash_success'] = 'Message enregistré avec succès.';
            header('Location: index.php?page=contact');
            exit;
        } else {
            $errorMessage = "Une erreur est survenue lors de l'enregistrement du message.";
        }
    }

    renderContactPage($successMessage, $errorMessage);
}