<hr>

<footer class="site-footer">
    <div class="footer-top">

        <nav class="footer-links" aria-label="Liens légaux">
            <a href="index.php?page=politique-confidentialite">Confidentialité</a>
            <a href="index.php?page=mentions-legales">Mentions légales</a>
            <a href="index.php?page=cgu">CGU</a>
        </nav>

        <div class="footer-address">
            <span>Kervadec</span>
            <span>56400 Pluneret,</span>
            <span>Morbihan - Bretagne, France</span>
        </div>

        <div class="footer-socials">
            <a href="#" aria-label="Accéder à notre page Facebook">
                <i class="fa-brands fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="#" aria-label="Accéder à notre page Instagram">
                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
            </a>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 Fournier Roux - Tous droits réservés</p>
    </div>
</footer>

</div>

<!-- Script global (menu burger) -->
<script src="public/assets/js/common/menu.js" defer></script>

<!-- Script spécifique à la page accueil -->
<?php if (isset($_GET['page']) && $_GET['page'] === 'accueil'): ?>
    <script src="public/assets/js/home/lightbox.js" defer></script>
<?php endif; ?>

<!-- Script spécifique à la page galerie -->
<?php if (isset($_GET['page']) && $_GET['page'] === 'galerie'): ?>
    <script src="public/assets/js/gallery/thumb-gallery.js" defer></script>
    <script src="public/assets/js/gallery/audio-playlist.js" defer></script>
<?php endif; ?>

<!-- Script spécifique à la page nid -->
<?php if (isset($_GET['page']) && $_GET['page'] === 'nid'): ?>
    <script src="public/assets/js/pages/nid-slider.js" defer></script>
<?php endif; ?>

<!-- Script spécifique à la page inaturalist -->
<?php if (isset($_GET['page']) && $_GET['page'] === 'inaturalist'): ?>
    <script src="public/assets/js/pages/inaturalist.js" defer></script>
<?php endif; ?>

</body>
</html>