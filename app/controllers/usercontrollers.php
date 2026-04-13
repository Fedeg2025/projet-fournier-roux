<?php

// =========================
// MODÈLE DE SUPPRESSION DE COMPTE
// Ce modèle permet de gérer la suppression directe
// du compte utilisateur
// =========================
require_once BASE_PATH . '/app/models/suppression-compte.php';


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
$erreur = '';
$succes = '';
$utilisateur = $_SESSION['user'];


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
        $erreur = 'Requête invalide (CSRF).';
    } else {

        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        // =========================
        // SUPPRESSION DIRECTE DU COMPTE
        // =========================
        if (isset($_POST['action']) && $_POST['action'] === 'delete_account') {

            // Un administrateur ne peut pas supprimer son propre compte
            if ($_SESSION['user']['role'] === 'admin') {
                $erreur = 'Un administrateur ne peut pas supprimer son compte.';
            } else {
                $suppression_reussie = deleteAccountWithRelatedData($pdo, $id_utilisateur);

                if ($suppression_reussie) {
                    session_unset();
                    session_destroy();
                    header('Location: index.php?page=accueil');
                    exit;
                } else {
                    $erreur = 'Une erreur est survenue lors de la suppression du compte.';
                }
            }

        } else {

            // =========================
            // MISE À JOUR DU PROFIL
            // =========================
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
// AFFICHAGE DE LA PAGE PROFIL
// Cette vue affiche les informations utilisateur
// et les formulaires liés au compte
// =========================
require_once BASE_PATH . '/app/views/pages/header.php';
require_once BASE_PATH . '/app/views/utilisateur/profil.php';
require_once BASE_PATH . '/app/views/pages/footer.php';