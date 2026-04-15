<?php

// =========================
// MODÈLE UTILISATEUR
// =========================
require_once BASE_PATH . '/app/models/user.php';


// =========================
// AFFICHAGE D'UNE PAGE D'AUTHENTIFICATION
// Cette fonction charge la vue demandée
// avec le layout d'authentification
// =========================
function renderAuthPage($view, $errorMessage = '', $successMessage = '')
{
    require BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}


// =========================
// AFFICHAGE DU FORMULAIRE DE CONNEXION
// Cette fonction affiche la page de connexion
// =========================
function showLogin()
{
    $errorMessage = '';
    $successMessage = $_SESSION['flash_success'] ?? '';

    // Suppression du message flash après affichage
    if (isset($_SESSION['flash_success'])) {
        unset($_SESSION['flash_success']);
    }

    $view = BASE_PATH . '/app/views/pages/login.php';
    renderAuthPage($view, $errorMessage, $successMessage);
}


// =========================
// TRAITEMENT DU FORMULAIRE DE CONNEXION
// Cette fonction vérifie les identifiants utilisateur
// =========================
function processLogin()
{
    global $pdo;

    $errorMessage = '';
    $successMessage = $_SESSION['flash_success'] ?? '';

    // Suppression du message flash après affichage
    if (isset($_SESSION['flash_success'])) {
        unset($_SESSION['flash_success']);
    }

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = 'Requête invalide (CSRF).';
    } else {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['mot_de_passe'] ?? '';

        // Validation des champs
        if (empty($email) || empty($password)) {
            $errorMessage = 'Champs obligatoires.';
        } else {
            $user = findUserByEmail($pdo, $email);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['mot_de_passe'])) {

                // Sécurisation de la session
                session_regenerate_id(true);

                $_SESSION['user'] = $user;
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                // Redirection vers l'accueil
                header('Location: index.php?page=accueil');
                exit;
            } else {
                $errorMessage = 'Identifiants incorrects.';
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/login.php';
    renderAuthPage($view, $errorMessage, $successMessage);
}


// =========================
// AFFICHAGE DU FORMULAIRE D'INSCRIPTION
// Cette fonction affiche la page d'inscription
// =========================
function showRegister()
{
    $errorMessage = '';
    $successMessage = '';

    $view = BASE_PATH . '/app/views/pages/register.php';
    renderAuthPage($view, $errorMessage, $successMessage);
}


// =========================
// TRAITEMENT DU FORMULAIRE D'INSCRIPTION
// Cette fonction crée un nouvel utilisateur
// =========================
function processRegister()
{
    global $pdo;

    $errorMessage = '';
    $successMessage = '';

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = 'Requête invalide (CSRF).';
    } else {
        $lastName = trim($_POST['nom'] ?? '');
        $firstName = trim($_POST['prenom'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['mot_de_passe'] ?? '';
        $registerConsent = $_POST['register_consent'] ?? '';

        // Validation des champs
        if (empty($lastName) || empty($firstName) || empty($email) || empty($password)) {
            $errorMessage = 'Tous les champs sont obligatoires.';
        } elseif (empty($registerConsent)) {
            $errorMessage = 'Vous devez accepter les conditions.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Email invalide.';
        } elseif (strlen($password) < 8) {
            $errorMessage = 'Mot de passe trop court.';
        } else {
            $user = findUserByEmail($pdo, $email);

            // Vérification si l'utilisateur existe déjà
            if ($user) {
                $errorMessage = 'Email déjà utilisé.';
            } else {

                // Création de l'utilisateur
                createUser($pdo, $lastName, $firstName, $email, $password);

                $_SESSION['flash_success'] = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                // Redirection vers la page de connexion
                header('Location: index.php?page=login');
                exit;
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/register.php';
    renderAuthPage($view, $errorMessage, $successMessage);
}


// =========================
// REDIRECTION POUR MOT DE PASSE OUBLIÉ
// Cette fonction empêche l'accès à ces pages
// =========================
function redirectForgotPassword()
{
    header('Location: index.php?page=login');
    exit;
}


// =========================
// TRAITEMENT DE LA DÉCONNEXION
// Cette fonction détruit la session utilisateur
// =========================
function processLogout()
{
    // Vérification de la méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=accueil');
        exit;
    }

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    // Suppression de la session
    session_unset();
    session_destroy();

    // Redirection vers l'accueil
    header('Location: index.php?page=accueil');
    exit;
}