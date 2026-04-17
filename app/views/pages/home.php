<!-- =========================
     PAGE D'ACCUEIL
     Cette vue présente l’association,
     le Fournier roux et une galerie d’images
     ========================= -->

<main id="main-content" class="accueil-page">
  <h1 class="visually-hidden">Accueil - Association Les Fourniers roux</h1>

  <?php if (isset($_GET['message']) && $_GET['message'] === 'demande_envoyee'): ?>
    <div class="success-message">
      Votre demande de suppression a bien été envoyée.
    </div>
  <?php endif; ?>

  <!-- =========================
       INTRODUCTION
       Présentation de l’association
       et du Fournier roux
       ========================= -->
  <section class="accueil-intro" aria-labelledby="bienvenue-title">
    <!-- En-tête visuel -->
    <div class="section-bienvenue__header">
      <div class="section-bienvenue__title-wrap">
        <h2 id="bienvenue-title" class="section-bienvenue__title">
          Bienvenue chez Les Fourniers
        </h2>
      </div>

      <div class="section-bienvenue__intro" aria-hidden="true">
        <span class="section-bienvenue__intro-line"></span>
        <span class="section-bienvenue__intro-text">INTRO</span>
        <span class="section-bienvenue__intro-line"></span>
      </div>
    </div>

    <!-- Contenu limité -->
    <div class="accueil-intro__content">
      <div class="text-border">
        <p>
          Créée au début des années 2000 par des amoureux de la nature, l’association
          <strong>Les Fourniers roux</strong> est née d’une fascination pour cet oiseau discret
          mais extraordinaire, capable de construire de véritables petits refuges en argile.
          Au fil des années, l’association s’est donné pour mission de faire découvrir cette
          espèce au plus grand nombre, de transmettre des connaissances accessibles et de
          sensibiliser chacun à la préservation de la biodiversité. Ce site a été imaginé comme
          une fenêtre ouverte sur l’univers du Fournier roux : un lieu pour observer, apprendre,
          comprendre et s’émerveiller. À travers ses contenus, il vise à rapprocher le public de
          la nature et à encourager une attention plus consciente au vivant.
        </p>
      </div>
    </div>
  </section>

  <!-- =========================
       CARROUSEL D’IMAGES
       ========================= -->

  <?php
  $carouselImages = [
    [
      'file' => 'fournier_roux2.webp',
      'alt'  => 'Fournier roux perché sur une branche, observant son environnement'
    ],
    [
      'file' => 'fournier_roux3.webp',
      'alt'  => 'Nid de fournier roux en argile avec un oiseau à l’intérieur'
    ],
    [
      'file' => 'fournier_roux4.webp',
      'alt'  => 'Fournier roux perché sur une branche fine dans la végétation'
    ],
    [
      'file' => 'fournier_roux5.webp',
      'alt'  => 'Fournier roux posé dans un environnement naturel verdoyant'
    ],
    [
      'file' => 'fournier_roux6.webp',
      'alt'  => 'Trois fourniers roux perchés côte à côte sur une structure'
    ],
    [
      'file' => 'fournier_roux7.webp',
      'alt'  => 'Fournier roux sortant de son nid en terre fixé à un arbre'
    ]
  ];
  ?>

  <section class="accueil-carousel" aria-labelledby="carousel-title">
    <h2 id="carousel-title" class="visually-hidden">Carrousel d’images du Fournier roux</h2>

    <div class="container">
      <div class="desktop-carousel" id="desktopCarousel">
        <button class="desktop-carousel__btn desktop-carousel__btn--prev" type="button" aria-label="Image précédente">
          ‹
        </button>

        <div class="desktop-carousel__track">
          <?php foreach ($carouselImages as $index => $image): ?>
            <div class="desktop-carousel__slide <?= $index === 0 ? 'is-active' : '' ?>">
              <img
                src="public/assets/images/carousel/<?= htmlspecialchars($image['file']) ?>"
                alt="<?= htmlspecialchars($image['alt']) ?>"
                loading="lazy">
            </div>
          <?php endforeach; ?>
        </div>

        <button class="desktop-carousel__btn desktop-carousel__btn--next" type="button" aria-label="Image suivante">
          ›
        </button>
      </div>
    </div>
  </section>

  <!-- =========================
       SECTION SYMBOLIQUE
       ========================= -->
  <section class="accueil-contenu" aria-labelledby="symbolique-title">
    <header class="section-header">
      <h2 id="symbolique-title" class="visually-hidden">Symbolique du Fournier roux</h2>
    </header>

    <div class="text-border">
      <p>
        En Amérique du Sud, on dit que si un Fournier roux construit son nid dans une maison,
        c’est un signe de prospérité et d’union. Selon certaines croyances, son nid attire le
        travail, l’harmonie et le bien-être. Il représente l’effort, la persévérance et la
        construction de quelque chose de solide — des valeurs qui évoquent la vie familiale
        et le progrès.
      </p>
    </div>
  </section>

  <!-- =========================
       CONTENU COMPLÉMENTAIRE
       ========================= -->
  <article class="accueil-contenu" aria-labelledby="accueil-contenu-title">
    <header class="section-header">
      <h2 id="accueil-contenu-title" class="visually-hidden">Habitat, comportement et portée symbolique du Fournier roux</h2>
    </header>

    <section aria-label="Texte de présentation complémentaire">
      <div class="text-border">
        <p>
          D’un point de vue pratique, le Fournier roux cherche toujours des endroits protégés du vent
          et de la pluie, où il peut facilement trouver de la boue et des petites branches pour
          construire son nid caractéristique en forme de four. Mais pour ceux qui croient aux
          messages de la nature, son choix n’est pas un hasard : c’est un signe d’équilibre,
          d’abondance et d’un foyer bien enraciné.
        </p>

        <p>
          Cet oiseau est également admiré pour sa capacité à bâtir avec patience et précision.
          Son nid, robuste et ingénieux, symbolise souvent la stabilité, l’engagement et la
          protection du foyer. Dans de nombreuses cultures, sa présence près d’une maison est
          perçue comme un bon présage et une invitation à prendre soin de ce que l’on construit
          jour après jour.
        </p>
      </div>
    </section>
  </article>

  <!-- =========================
       GALERIE D’IMAGES
       ========================= -->
  <section id="galerie" class="accueil-galerie" aria-label="Galerie de photos du Fournier roux">
    <div class="galerie-grid">

      <article class="paysage">
        <a href="public/assets/images/fournier_roux1.webp" aria-label="Fournier roux perché sur une branche">
          <img
            src="public/assets/images/fournier_roux1.webp"
            alt="Fournier roux perché sur une branche dans un environnement naturel"
            loading="lazy">
        </a>
      </article>

      <article class="paysage">
        <a href="public/assets/images/fournier_roux2.webp" aria-label="Fournier roux près de son nid">
          <img
            src="public/assets/images/fournier_roux2.webp"
            alt="Fournier roux observé près de son nid en terre"
            loading="lazy">
        </a>
      </article>

      <article class="paysage">
        <a href="public/assets/images/fournier_roux3.webp" aria-label="Fournier roux dans la végétation">
          <img
            src="public/assets/images/fournier_roux3.webp"
            alt="Fournier roux au milieu de la végétation avec son plumage brun et roux"
            loading="lazy">
        </a>
      </article>

      <article class="paysage">
        <a href="public/assets/images/fournier_roux4.webp" aria-label="Nid de Fournier roux en forme de four">
          <img
            src="public/assets/images/fournier_roux4.webp"
            alt="Nid de Fournier roux construit en boue avec sa forme caractéristique de four"
            loading="lazy">
        </a>
      </article>

      <article class="paysage">
        <a href="public/assets/images/fournier_roux5.webp" aria-label="Fournier roux au sol">
          <img
            src="public/assets/images/fournier_roux5.webp"
            alt="Fournier roux marchant au sol dans son habitat naturel"
            loading="lazy">
        </a>
      </article>

      <article class="paysage">
        <a href="public/assets/images/fournier_roux6.webp" aria-label="Fournier roux en observation">
          <img
            src="public/assets/images/fournier_roux6.webp"
            alt="Fournier roux en train d’observer son environnement"
            loading="lazy">
        </a>
      </article>

    </div>
  </section>

  <!-- =========================
       LIGHTBOX PERSONNALISÉE
       Permet d’afficher les images en grand
       ========================= -->
  <aside class="custom-lightbox" id="custom-lightbox" aria-hidden="true">
    <button class="lightbox-close" id="lightbox-close" type="button" aria-label="Fermer l’image">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>

    <button class="lightbox-prev" id="lightbox-prev" type="button" aria-label="Image précédente">
      <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
    </button>

    <img class="lightbox-image" id="lightbox-image" src="" alt="">

    <button class="lightbox-next" id="lightbox-next" type="button" aria-label="Image suivante">
      <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
    </button>
  </aside>
</main>