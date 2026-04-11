<?php

// =========================
// MODÈLE UTILISATEUR
// =========================
require_once BASE_PATH . '/app/models/User.php';

// =========================
// PAGE COURANTE
// =========================
$page = $_GET['page'] ?? 'login';

// =========================
// INSCRIPTION
// =========================
if ($page === 'register') {

    $erreur = '';
    $succes = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $erreur = 'Requête invalide (CSRF).';
        } else {

            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = strtolower(trim($_POST['email'] ?? ''));
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $register_consent = $_POST['register_consent'] ?? '';

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

                if ($utilisateur) {
                    $erreur = 'Email déjà utilisé.';
                } else {
                    createUser($pdo, $nom, $prenom, $email, $mot_de_passe);

                    $_SESSION['flash_success'] = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    header('Location: index.php?page=login');
                    exit;
                }
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/register.php';
    require_once BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}

// =========================
// CONNEXION
// =========================
if ($page === 'login') {

    $erreur = '';
    $succes = $_SESSION['flash_success'] ?? '';

    if (isset($_SESSION['flash_success'])) {
        unset($_SESSION['flash_success']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $erreur = 'Requête invalide (CSRF).';
        } else {

            $email = strtolower(trim($_POST['email'] ?? ''));
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';

            if (empty($email) || empty($mot_de_passe)) {
                $erreur = 'Champs obligatoires.';
            } else {

                $utilisateur = findUserByEmail($pdo, $email);

                if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = $utilisateur;
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    header('Location: index.php?page=accueil');
                    exit;
                } else {
                    $erreur = 'Identifiants incorrects.';
                }
            }
        }
    }

    $view = BASE_PATH . '/app/views/pages/login.php';
    require_once BASE_PATH . '/app/views/layouts/auth-layout.php';
    exit;
}

// =========================
// MOT DE PASSE OUBLIÉ DÉSACTIVÉ
// =========================
if ($page === 'mot-de-passe-oublie' || $page === 'nouveau-mot-de-passe') {
    header('Location: index.php?page=login');
    exit;
}

// =========================
// DÉCONNEXION
// =========================
if ($page === 'logout') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=accueil');
        exit;
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Requête invalide (CSRF).');
    }

    session_unset();
    session_destroy();

    header('Location: index.php?page=accueil');
    exit;
}