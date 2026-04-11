<!-- =========================
     PIED DE PAGE (FOOTER)
     Ce fichier contient le pied de page du site
     ainsi que le chargement des scripts JavaScript
     ========================= -->

<footer class="site-footer">
    <div class="footer-top">

        <!-- =========================
             LIENS LÉGAUX
             ========================= -->
        <nav class="footer-links" aria-label="Liens légaux">
            <a href="index.php?page=politique-confidentialite">Confidentialité</a>
            <a href="index.php?page=mentions-legales">Mentions légales</a>
            <a href="index.php?page=cgu">CGU</a>
        </nav>

        <!-- =========================
             ADRESSE
             ========================= -->
        <div class="footer-address">
            <span>Kervadec</span>
            <span>56400 Pluneret,</span>
            <span>Morbihan - Bretagne, France</span>
        </div>

        <!-- =========================
             RÉSEAUX SOCIAUX
             ========================= -->
        <div class="footer-socials">
            <a href="#" aria-label="Accéder à notre page Facebook">
                <i class="fa-brands fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="#" aria-label="Accéder à notre page Instagram">
                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
            </a>
        </div>

    </div>

    <!-- =========================
         COPYRIGHT
         ========================= -->
    <div class="footer-bottom">
        <p>© 2026 Fournier Roux - Tous droits réservés</p>
    </div>
</footer>

</div> <!-- fermeture de la structure principale (app-shell) -->


<!-- =========================
     SCRIPT GLOBAL
     Menu burger utilisé sur toutes les pages
     ========================= -->
<script src="public/assets/js/common/menu.js" defer></script>


<!-- =========================
     CHARGEMENT DES SCRIPTS SPÉCIFIQUES
     Les scripts sont chargés en fonction de la page courante
     ========================= -->
<?php
$page = $_GET['page'] ?? 'accueil';
?>

<?php if ($page === 'accueil'): ?>
    <script src="public/assets/js/home/lightbox.js" defer></script>
<?php endif; ?>

<?php if ($page === 'galerie'): ?>
    <script src="public/assets/js/gallery/thumb-gallery.js" defer></script>
    <script src="public/assets/js/gallery/audio-playlist.js" defer></script>
<?php endif; ?>

<?php if ($page === 'nid'): ?>
    <script src="public/assets/js/pages/nid-slider.js" defer></script>
<?php endif; ?>

<?php if ($page === 'inaturalist'): ?>
    <script src="public/assets/js/pages/inaturalist.js" defer></script>
<?php endif; ?>

</body>
</html>