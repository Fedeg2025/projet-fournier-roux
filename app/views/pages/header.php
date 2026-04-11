
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fournier Roux</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="public/assets/css/main.css">
</head>

<body>

    <div class="app-shell">

        <header class="site-header">

            <div class="nav-header">

                <button class="burger-btn" id="burger-btn" type="button" aria-label="Ouvrir le menu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>

                <div class="brand-box">
                    <div class="logo-box">
                        <a href="index.php?page=accueil" aria-label="Retour à l'accueil">
                            <img src="public/assets/images/logoCreator_imagetologo.jpg" alt="Logo Fournier Roux">
                        </a>
                    </div>

                    <p class="site-title">
                        <a href="index.php?page=accueil">
                            Fournier <span>roux</span>
                        </a>
                    </p>
                </div>

                <div class="profile-box">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?page=profil">Profil</a>
                        <form method="POST" action="index.php?page=logout" style="display:inline;">
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                            >
                            <button type="submit" class="logout-link">
                                Déconnexion
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?page=login">Connexion</a>
                    <?php endif; ?>
                </div>

                <div class="mobile-profile-box">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?page=profil" aria-label="Profil">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </a>
                        <form method="POST" action="index.php?page=logout" style="display:inline;">
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>"
                            >
                            <button type="submit" class="logout-link" aria-label="Déconnexion">
                                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?page=login" aria-label="Connexion">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <nav class="main-nav" id="main-nav" aria-label="Navigation principale">
                <a href="index.php?page=accueil">Accueil</a>
                <a href="index.php?page=oiseau">L’oiseau</a>
                <a href="index.php?page=nid">Construction du nid</a>
                <a href="index.php?page=galerie">Galerie</a>
                <a href="index.php?page=contact">Contact</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?page=articles">Actualités</a>
                    <a href="index.php?page=ressources">Ressources pédagogiques</a>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="index.php?page=admin">Admin</a>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>

            <div class="hero-image">
                <div class="hero-overlay">
                    <h2>Des bâtisseurs exceptionnels</h2>
                </div>
            </div>

        </header>

    </div>