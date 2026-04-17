// =========================
// ACCESSIBILITÉ CLAVIER
// Navigation clavier globale
// =========================

document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const skipLink = document.querySelector('.skip-link');
    const mainContent = document.getElementById('main-content');
    const nav = document.getElementById('main-nav');
    const burgerBtn = document.getElementById('burger-btn');
    const navLinks = nav ? nav.querySelectorAll('a') : [];

    // =========================
    // DÉTECTION DU CLAVIER
    // Permet d’afficher le focus
    // uniquement lors de la navigation clavier
    // =========================
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Tab' || event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            body.classList.add('user-is-tabbing');
        }
    });

    document.addEventListener('mousedown', function () {
        body.classList.remove('user-is-tabbing');
    });

    // =========================
    // LIEN D’ACCÈS RAPIDE
    // Place le focus sur le contenu principal
    // =========================
    if (skipLink && mainContent) {
        skipLink.addEventListener('click', function () {
            mainContent.setAttribute('tabindex', '-1');
            mainContent.focus();
        });
    }

    // =========================
    // NAVIGATION CLAVIER DANS LE MENU
    // Flèches gauche / droite
    // =========================
    if (navLinks.length > 0) {
        navLinks.forEach(function (link, index) {
            link.addEventListener('keydown', function (event) {
                if (event.key === 'ArrowRight') {
                    event.preventDefault();

                    if (navLinks[index + 1]) {
                        navLinks[index + 1].focus();
                    }
                }

                if (event.key === 'ArrowLeft') {
                    event.preventDefault();

                    if (navLinks[index - 1]) {
                        navLinks[index - 1].focus();
                    }
                }
            });
        });
    }

    // =========================
    // MENU BURGER
    // Gestion minimale clavier
    // =========================
    if (burgerBtn && nav) {
        burgerBtn.addEventListener('click', function () {
            const isExpanded = burgerBtn.getAttribute('aria-expanded') === 'true';

            burgerBtn.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            nav.classList.toggle('is-open');

            if (!isExpanded && navLinks.length > 0) {
                navLinks[0].focus();
            }
        });

        burgerBtn.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                burgerBtn.click();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && nav.classList.contains('is-open')) {
                nav.classList.remove('is-open');
                burgerBtn.setAttribute('aria-expanded', 'false');
                burgerBtn.focus();
            }
        });
    }
});