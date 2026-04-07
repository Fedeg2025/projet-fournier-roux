<?php

require_once __DIR__ . '/../models/demande-suppression-compte.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// Génération du jeton CSRF s'il n'existe pas encore.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification CSRF.
    if (
        !isset($_POST['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $erreur = 'Requête invalide (CSRF).';
    } else {
        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        if (isset($_POST['action']) && $_POST['action'] === 'delete_account_request') {
            $motif = trim($_POST['motif'] ?? '');

            if (hasPendingDeleteAccountRequest($pdo, $id_utilisateur)) {
                $erreur = 'Une demande de suppression est déjà en attente de traitement.';
            } else {
                $demande_creee = createDeleteAccountRequest($pdo, $id_utilisateur, $motif ?: null);

                if ($demande_creee) {
                    $succes = 'Votre demande de suppression de compte a bien été envoyée.';

                    // Régénération du jeton CSRF après succès.
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } else {
                    $erreur = 'Une erreur est survenue lors de l’envoi de la demande.';
                }
            }
        } else {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');

            // Validation.
            if (empty($nom) || empty($prenom)) {
                $erreur = 'Le nom et le prénom sont obligatoires.';
            } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 100) {
                $erreur = 'Le nom doit contenir entre 2 et 100 caractères.';
            } elseif (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 100) {
                $erreur = 'Le prénom doit contenir entre 2 et 100 caractères.';
            } else {
                $requete = $pdo->prepare("
                    UPDATE utilisateurs
                    SET nom = ?, prenom = ?
                    WHERE id_utilisateur = ?
                ");

                $mise_a_jour_reussie = $requete->execute([$nom, $prenom, $id_utilisateur]);

                if ($mise_a_jour_reussie) {
                    $_SESSION['user']['nom'] = $nom;
                    $_SESSION['user']['prenom'] = $prenom;
                    $succes = 'Profil mis à jour avec succès.';

                    // Régénération du jeton CSRF après succès.
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } else {
                    $erreur = 'Une erreur est survenue lors de la mise à jour du profil.';
                }
            }
        }
    }
}

$utilisateur = $_SESSION['user'];

require_once __DIR__ . '/../views/pages/header.php';
require_once __DIR__ . '/../views/utilisateur/profil.php';
require_once __DIR__ . '/../views/pages/footer.php';