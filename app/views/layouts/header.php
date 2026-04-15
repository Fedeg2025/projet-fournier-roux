<!-- =========================
     LAYOUT PRINCIPAL - HEADER
     Ce fichier contient l’en-tête du site :
     navigation, logo, accès utilisateur
     ========================= -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- =========================
         MÉTADONNÉES
         ========================= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        name="description"
        content="Découvrez le Fournier roux, un oiseau bâtisseur exceptionnel, à travers des contenus pédagogiques, une galerie multimédia et des observations récentes."
    >
    <title>Les Fourniers roux - Des bâtisseurs exceptionnels</title>

    <!-- =========================
         STYLES
         ========================= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="public/assets/css/main.css">
</head>

<body>
    <!-- =========================
         STRUCTURE PRINCIPALE
         ========================= -->
    <div class="structure-site">
        <!-- =========================
             EN-TÊTE DU SITE
             ========================= -->
        <header class="entete-site">
            <!-- =========================
                 BARRE DE NAVIGATION HAUTE
                 ========================= -->
            <div class="entete-site__barre">
                <!-- Bouton menu mobile -->
                <button
                    class="entete-site__bouton-menu"
                    id="burger-btn"
                    type="button"
                    aria-label="Ouvrir le menu principal"
                    aria-controls="main-nav"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>

                <!-- =========================
                     LOGO + NOM DU SITE
                     ========================= -->
                <div class="entete-site__marque">
                    <div class="entete-site__logo">
                        <a href="index.php?page=accueil" aria-label="Retour à l'accueil">
                            <img
                                src="public/assets/images/logoCreator_imagetologo.jpg"
                                alt="Logo de l’association Fournier Roux"
                            >
                        </a>
                    </div>

                    <p class="entete-site__titre">
                        <a href="index.php?page=accueil">
                            Fournier <span>roux</span>
                        </a>
                    </p>
                </div>

                <!-- =========================
                     ZONE UTILISATEUR (DESKTOP)
                     ========================= -->
                <div class="entete-site__profil">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?page=profil">Profil</a>

                        <!-- Formulaire de déconnexion sécurisé -->
                        <form method="POST" action="index.php?page=logout" style="display:inline;">
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                            >
                            <button type="submit" class="entete-site__lien-deconnexion">
                                Déconnexion
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?page=login">Connexion</a>
                    <?php endif; ?>
                </div>

                <!-- =========================
                     ZONE UTILISATEUR (MOBILE)
                     ========================= -->
                <div class="entete-site__profil-mobile">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?page=profil" aria-label="Accéder au profil">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </a>

                        <form method="POST" action="index.php?page=logout" style="display:inline;">
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                            >
                            <button
                                type="submit"
                                class="entete-site__lien-deconnexion"
                                aria-label="Se déconnecter"
                            >
                                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?page=login" aria-label="Accéder à la connexion">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- =========================
                 NAVIGATION PRINCIPALE
                 ========================= -->
            <nav class="entete-site__navigation" id="main-nav" aria-label="Navigation principale">
                <a href="index.php?page=accueil">Accueil</a>
                <a href="index.php?page=oiseau">L’oiseau</a>
                <a href="index.php?page=nid">Le Nid</a>
                <a href="index.php?page=galerie">Galerie</a>
                <a href="index.php?page=contact">Contact</a>

                <!-- Liens supplémentaires pour utilisateur connecté -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?page=articles">Actualités</a>
                    <a href="index.php?page=ressources">Ressources pédagogiques</a>

                    <!-- Accès administrateur -->
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="index.php?page=admin">Admin</a>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>

            <!-- =========================
                 IMAGE HERO (BANNIÈRE)
                 ========================= -->
            <div class="entete-site__hero">
                <div class="entete-site__superposition">
                    <h2>Des bâtisseurs exceptionnels</h2>
                </div>
            </div>
        </header>