<?php

// Chargement du modèle utilisateur contenant les fonctions
// nécessaires à la gestion des comptes (recherche, création, etc.).
require_once __DIR__ . '/../models/User.php';

// Vérifie que la session est démarrée.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Détermination de la page demandée via le paramètre GET.
// Si aucune page n'est spécifiée, la page de connexion est affichée par défaut.
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

/**
 * Génère un jeton CSRF s'il n'existe pas encore.
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * ---------------------------------------------------------
 * GESTION DE L'INSCRIPTION
 * ---------------------------------------------------------
 */
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
                $erreur = "Email invalide.";
            } elseif (strlen($mot_de_passe) < 8) {
                $erreur = 'Mot de passe trop court.';
            } else {

                $utilisateur = findUserByEmail($pdo, $email);

                if ($utilisateur) {
                    $erreur = 'Email déjà utilisé.';
                } else {
                    createUser($pdo, $nom, $prenom, $email, $mot_de_passe);
                    $succes = 'Compte créé avec succès.';
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                }
            }
        }
    }

    require_once __DIR__ . '/../views/pages/auth-header.php';
    require_once __DIR__ . '/../views/pages/register.php';
    require_once __DIR__ . '/../views/pages/auth-footer.php';
    exit;
}

/**
 * ---------------------------------------------------------
 * GESTION DE LA CONNEXION
 * ---------------------------------------------------------
 */
if ($page === 'login') {

    $erreur = '';

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

    require_once __DIR__ . '/../views/pages/auth-header.php';
    require_once __DIR__ . '/../views/pages/login.php';
    require_once __DIR__ . '/../views/pages/auth-footer.php';
    exit;
}

/**
 * ---------------------------------------------------------
 * MOT DE PASSE OUBLIÉ
 * ---------------------------------------------------------
 */
if ($page === 'mot-de-passe-oublie') {

    $erreur = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $erreur = 'Requête invalide (CSRF).';
        } else {

            $email = strtolower(trim($_POST['email'] ?? ''));

            if (empty($email)) {
                $erreur = 'Veuillez entrer un email.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreur = 'Email invalide.';
            } else {
                $utilisateur = findUserByEmail($pdo, $email);

                if (!$utilisateur) {
                    $erreur = 'Aucun compte trouvé avec cet email.';
                } else {
                    $_SESSION['reset_email'] = $email;
                    header('Location: index.php?page=nouveau-mot-de-passe');
                    exit;
                }
            }
        }
    }

    require_once __DIR__ . '/../views/pages/auth-header.php';
    require_once __DIR__ . '/../views/pages/mot-de-passe-oublie.php';
    require_once __DIR__ . '/../views/pages/auth-footer.php';
    exit;
}

/**
 * ---------------------------------------------------------
 * NOUVEAU MOT DE PASSE
 * ---------------------------------------------------------
 */
if ($page === 'nouveau-mot-de-passe') {

    $erreur = '';
    $succes = '';

    if (empty($_SESSION['reset_email'])) {
        header('Location: index.php?page=mot-de-passe-oublie');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $erreur = 'Requête invalide (CSRF).';
        } else {

            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $confirmation = $_POST['confirmation_mot_de_passe'] ?? '';
            $email = $_SESSION['reset_email'];

            if (empty($mot_de_passe) || empty($confirmation)) {
                $erreur = 'Veuillez remplir tous les champs.';
            } elseif (strlen($mot_de_passe) < 8) {
                $erreur = 'Mot de passe trop court.';
            } elseif ($mot_de_passe !== $confirmation) {
                $erreur = 'Les mots de passe ne correspondent pas.';
            } else {
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $sql = "UPDATE utilisateur SET mot_de_passe = :mot_de_passe WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':mot_de_passe' => $mot_de_passe_hash,
                    ':email' => $email
                ]);

                unset($_SESSION['reset_email']);

                $succes = 'Mot de passe modifié avec succès.';
            }
        }
    }

    require_once __DIR__ . '/../views/pages/auth-header.php';
    require_once __DIR__ . '/../views/pages/nouveau-mot-de-passe.php';
    require_once __DIR__ . '/../views/pages/auth-footer.php';
    exit;
}

/**
 * ---------------------------------------------------------
 * GESTION DE LA DÉCONNEXION
 * ---------------------------------------------------------
 */
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