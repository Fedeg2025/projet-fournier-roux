<!-- =========================
     PAGE INATURALIST
     Cette vue permet d’afficher
     les observations du Fournier roux
     via l’API iNaturalist
     ========================= -->

<main class="page-inaturalist">

    <!-- =========================
         EN-TÊTE DE LA PAGE
         ========================= -->
    <section class="hero-inaturalist">
        <h1 class="hero-inaturalist__title">Observations iNaturalist</h1>

        <p class="hero-inaturalist__text">
            Cette page permet de consulter des observations récentes du Fournier roux
            grâce à l’API iNaturalist.
        </p>
    </section>

    <!-- =========================
         GALERIE DES OBSERVATIONS
         Le contenu est chargé dynamiquement en JavaScript
         ========================= -->
    <section class="galerie-inaturalist">
        <div id="observations-list" class="galerie-inaturalist__list">
            <p class="galerie-inaturalist__loading">Chargement des observations...</p>
        </div>
    </section>

    <!-- =========================
         ACTIONS UTILISATEUR
         Bouton permettant de charger plus d’observations
         ========================= -->
    <div class="actions-inaturalist">
        <button id="load-more-inat" class="actions-inaturalist__button" type="button">
            Voir plus
        </button>
    </div>

</main>