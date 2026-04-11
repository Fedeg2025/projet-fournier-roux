<?php

// =========================
// MODÈLE
// =========================
require_once BASE_PATH . '/app/models/demande-suppression-compte.php';

// =========================
// SÉCURITÉ
// =========================
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// =========================
// VARIABLES
// =========================
$erreur = '';
$succes = '';
$utilisateur = $_SESSION['user'];

// =========================
// TRAITEMENT FORMULAIRE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        !isset($_POST['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $erreur = 'Requête invalide (CSRF).';
    } else {

        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        // Demande de suppression de compte
        if (isset($_POST['action']) && $_POST['action'] === 'delete_account_request') {

            if ($_SESSION['user']['role'] === 'admin') {
                $erreur = 'Un administrateur ne peut pas supprimer son compte.';
            } else {
                $motif = trim($_POST['motif'] ?? '');

                if (hasPendingDeleteAccountRequest($pdo, $id_utilisateur)) {
                    $erreur = 'Une demande de suppression est déjà en attente de traitement.';
                } else {
                    $demande_creee = createDeleteAccountRequest($pdo, $id_utilisateur, $motif ?: null);

                    if ($demande_creee) {
                        $succes = 'Votre demande de suppression de compte a bien été envoyée.';
                    } else {
                        $erreur = 'Une erreur est survenue lors de l’envoi de la demande.';
                    }
                }
            }

        } else {
            // Mise à jour du profil
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');

            if (empty($nom) || empty($prenom)) {
                $erreur = 'Le nom et le prénom sont obligatoires.';
            } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 100) {
                $erreur = 'Le nom doit contenir entre 2 et 100 caractères.';
            } elseif (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 100) {
                $erreur = 'Le prénom doit contenir entre 2 et 100 caractères.';
            } else {
                $sql = "UPDATE utilisateurs
                        SET nom = ?, prenom = ?
                        WHERE id_utilisateur = ?";

                $stmt = $pdo->prepare($sql);
                $mise_a_jour_reussie = $stmt->execute([$nom, $prenom, $id_utilisateur]);

                if ($mise_a_jour_reussie) {
                    $_SESSION['user']['nom'] = $nom;
                    $_SESSION['user']['prenom'] = $prenom;
                    $utilisateur = $_SESSION['user'];
                    $succes = 'Profil mis à jour avec succès.';
                } else {
                    $erreur = 'Une erreur est survenue lors de la mise à jour du profil.';
                }
            }
        }
    }
}

// =========================
// AFFICHAGE
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/profil.php';
require_once BASE_PATH . '/app/views/pages/footer.php';