<?php

// =========================
// MODÈLE UTILISATEUR
// Ce contrôleur utilise le modèle utilisateur
// pour gérer le profil et la suppression du compte
// =========================
require_once BASE_PATH . '/app/models/user.php';


// =========================
// VÉRIFICATION DE L'AUTHENTIFICATION
// Cette page est réservée aux utilisateurs connectés
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}


// =========================
// INITIALISATION DES VARIABLES
// Ces variables sont utilisées dans la vue
// =========================
$errorMessage = '';
$successMessage = '';
$user = $_SESSION['user'];


// =========================
// TRAITEMENT DU FORMULAIRE
// Ce contrôleur gère :
// - la mise à jour du profil
// - la suppression directe du compte
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du token CSRF
    if (
        !isset($_POST['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $errorMessage = 'Requête invalide (CSRF).';
    } else {
        $userId = $_SESSION['user']['id_utilisateur'];

        // =========================
        // SUPPRESSION DIRECTE DU COMPTE
        // =========================
        if (isset($_POST['action']) && $_POST['action'] === 'delete_account') {

            // Un administrateur ne peut pas supprimer son propre compte
            if ($_SESSION['user']['role'] === 'admin') {
                $errorMessage = 'Un administrateur ne peut pas supprimer son compte.';
            } else {
                $deleteSuccess = deleteAccountWithRelatedData($pdo, $userId);

                if ($deleteSuccess) {
                    session_unset();
                    session_destroy();
                    header('Location: index.php?page=accueil');
                    exit;
                } else {
                    $errorMessage = 'Une erreur est survenue lors de la suppression du compte.';
                }
            }

        } else {

            // =========================
            // MISE À JOUR DU PROFIL
            // =========================
            $lastName = trim($_POST['nom'] ?? '');
            $firstName = trim($_POST['prenom'] ?? '');

            if (empty($lastName) || empty($firstName)) {
                $errorMessage = 'Le nom et le prénom sont obligatoires.';
            } elseif (mb_strlen($lastName) < 2 || mb_strlen($lastName) > 100) {
                $errorMessage = 'Le nom doit contenir entre 2 et 100 caractères.';
            } elseif (mb_strlen($firstName) < 2 || mb_strlen($firstName) > 100) {
                $errorMessage = 'Le prénom doit contenir entre 2 et 100 caractères.';
            } else {
                $updateSuccess = updateUserProfile($pdo, $userId, $lastName, $firstName);

                if ($updateSuccess) {
                    $_SESSION['user']['nom'] = $lastName;
                    $_SESSION['user']['prenom'] = $firstName;
                    $user = $_SESSION['user'];
                    $successMessage = 'Profil mis à jour avec succès.';
                } else {
                    $errorMessage = 'Une erreur est survenue lors de la mise à jour du profil.';
                }
            }
        }
    }
}


// =========================
// AFFICHAGE DE LA PAGE PROFIL
// Cette vue affiche les informations utilisateur
// et les formulaires liés au compte
// =========================
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/user/profile.php';
require_once BASE_PATH . '/app/views/layouts/footer.php';