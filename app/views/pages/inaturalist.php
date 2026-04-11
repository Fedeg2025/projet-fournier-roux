<!-- =========================
     PAGE INATURALIST
     Cette vue permet d’afficher
     les observations du Fournier roux
     via l’API iNaturalist
     ========================= -->

<main class="inat-page">

    <!-- =========================
         EN-TÊTE DE LA PAGE
         ========================= -->
    <section class="inat-hero">
        <h1 class="inat-title">Observations iNaturalist</h1>

        <p class="inat-text">
            Cette page permet de consulter des observations récentes du Fournier roux
            grâce à l’API iNaturalist.
        </p>
    </section>

    <!-- =========================
         GALERIE DES OBSERVATIONS
         Le contenu est chargé dynamiquement en JavaScript
         ========================= -->
    <section class="inat-gallery">
        <div id="observations-list" class="inat-list">
            <p class="inat-loading">Chargement des observations...</p>
        </div>
    </section>

    <!-- =========================
         ACTIONS UTILISATEUR
         Bouton permettant de charger plus d’observations
         ========================= -->
    <div class="inat-actions">
        <button id="load-more-inat" class="inat-button" type="button">
            Voir plus
        </button>
    </div>

</main>