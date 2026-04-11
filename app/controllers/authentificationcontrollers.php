<?php

// =========================
// MODÈLE UTILISATEUR
// =========================
require_once BASE_PATH . '/app/models/User.php';


// =========================
// AFFICHAGE DU FORMULAIRE DE CONNEXION
// Cette fonction affiche la page de connexion
// =========================
function afficherLogin()
{
    $erreur = '';
    $succes = $_SESSION['flash_success'] ?? '';

    // Suppression du message flash après affichage
    if (isset($_SESSION['flash_success'])) {
        unset($_SESSION['flash_success']);
    }

    $view = BASE_PATH . '/app/views/pages/login.php';
    require BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}


// =========================
// TRAITEMENT DU FORMULAIRE DE CONNEXION
// Cette fonction vérifie les identifiants utilisateur
// =========================
function traiterLogin()
{
    global $pdo;

    $erreur = '';
    $succes = $_SESSION['flash_success'] ?? '';

    // Suppression du message flash
    if (isset($_SESSION['flash_success'])) {
        unset($_SESSION['flash_success']);
    }

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreur = 'Requête invalide (CSRF).';
    } else {

        $email = strtolower(trim($_POST['email'] ?? ''));
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        // Vérification des champs
        if (empty($email) || empty($mot_de_passe)) {
            $erreur = 'Champs obligatoires.';
        } else {

            $utilisateur = findUserByEmail($pdo, $email);

            // Vérification du mot de passe
            if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {

                // Sécurisation de la session
                session_regenerate_id(true);

                $_SESSION['user'] = $utilisateur;
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                // Redirection vers l'accueil
                header('Location: index.php?page=accueil');
                exit;
            } else {
                $erreur = 'Identifiants incorrects.';
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/login.php';
    require BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}


// =========================
// AFFICHAGE DU FORMULAIRE D'INSCRIPTION
// Cette fonction affiche la page d'inscription
// =========================
function afficherRegister()
{
    $erreur = '';
    $succes = '';

    $view = BASE_PATH . '/app/views/pages/register.php';
    require BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}


// =========================
// TRAITEMENT DU FORMULAIRE D'INSCRIPTION
// Cette fonction crée un nouvel utilisateur
// =========================
function traiterRegister()
{
    global $pdo;

    $erreur = '';
    $succes = '';

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreur = 'Requête invalide (CSRF).';
    } else {

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $register_consent = $_POST['register_consent'] ?? '';

        // Validation des champs
        if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
            $erreur = 'Tous les champs sont obligatoires.';
        } elseif (empty($register_consent)) {
            $erreur = 'Vous devez accepter les conditions.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur = 'Email invalide.';
        } elseif (strlen($mot_de_passe) < 8) {
            $erreur = 'Mot de passe trop court.';
        } else {

            $utilisateur = findUserByEmail($pdo, $email);

            // Vérification si l'utilisateur existe déjà
            if ($utilisateur) {
                $erreur = 'Email déjà utilisé.';
            } else {

                // Création de l'utilisateur
                createUser($pdo, $nom, $prenom, $email, $mot_de_passe);

                $_SESSION['flash_success'] = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                // Redirection vers la page de connexion
                header('Location: index.php?page=login');
                exit;
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/register.php';
    require BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}


// =========================
// REDIRECTION POUR MOT DE PASSE OUBLIÉ
// Cette fonction empêche l'accès à ces pages
// =========================
function redirigerMotDePasseOublie()
{
    header('Location: index.php?page=login');
    exit;
}


// =========================
// TRAITEMENT DE LA DÉCONNEXION
// Cette fonction détruit la session utilisateur
// =========================
function traiterLogout()
{
    // Vérifie que la requête est en POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=accueil');
        exit;
    }

    // Vérification CSRF
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