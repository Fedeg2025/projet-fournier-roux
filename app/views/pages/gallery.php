<?php

// =========================
// RESSOURCES MÉDIAS
// Ce bloc prépare les chemins des images
// et des fichiers audio utilisés dans la galerie
// =========================
$assetBase = 'public/assets/images';

$galleryImages = [
    [
        'src' => $assetBase . '/img51.webp',
        'alt' => 'Fournier roux 51'
    ],
    [
        'src' => $assetBase . '/img52.webp',
        'alt' => 'Fournier roux 52'
    ],
    [
        'src' => $assetBase . '/img53.webp',
        'alt' => 'Fournier roux 53'
    ],
    [
        'src' => $assetBase . '/img54.webp',
        'alt' => 'Fournier roux 54'
    ],
    [
        'src' => $assetBase . '/img55.webp',
        'alt' => 'Fournier roux 55'
    ],
    [
        'src' => $assetBase . '/img56.webp',
        'alt' => 'Fournier roux 56'
    ],
    [
        'src' => $assetBase . '/img57.webp',
        'alt' => 'Fournier roux 57'
    ],
    [
        'src' => $assetBase . '/img58.webp',
        'alt' => 'Fournier roux 58'
    ],
    [
        'src' => $assetBase . '/img59.webp',
        'alt' => 'Fournier roux 59'
    ],
    [
        'src' => $assetBase . '/img60.webp',
        'alt' => 'Fournier roux 60'
    ],
];

$audioTracks = [
    [
        'src' => $assetBase . '/audios/XC932468%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'Chant territorial du Fournier roux pour défendre son nid.'
    ],
    [
        'src' => $assetBase . '/audios/XC943374%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.mp3',
        'type' => 'audio/mpeg',
        'label' => 'Duo vocal du couple, renforçant leur lien et leur coordination.'
    ],
    [
        'src' => $assetBase . '/audios/XC985697%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'Appel d’alerte face à une présence perçue comme une menace.'
    ],
    [
        'src' => $assetBase . '/audios/XC992354%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'Chant matinal marquant la présence du territoire.'
    ],
    [
        'src' => $assetBase . '/audios/XC1009595%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'Communication entre partenaires pendant la construction ou l’entretien du nid.'
    ],
];
?>

<!-- =========================
     PAGE GALERIE
     Cette vue présente une galerie multimédia
     composée d’images, de vidéos et d’enregistrements audio
     ========================= -->

<main class="page-galerie">

    <!-- =========================
         EN-TÊTE DE LA GALERIE
         ========================= -->
    <section class="hero-galerie">
        <div class="hero-galerie__content">
            <p class="hero-galerie__tag">Galerie multimédia</p>
            <h1>Galerie du <span>Fournier roux</span></h1>
            <p class="hero-galerie__text">
                Découvrez les vidéos et les enregistrements audio du Fournier roux.
            </p>
        </div>
    </section>

    <!-- =========================
         SECTION GALERIE PHOTO
         ========================= -->
    <section class="section-galerie section-galerie--photos">
        <div class="entete-section">
            <p class="entete-section__tag"></p>
            <h2>Galerie photo</h2>
            <p>
                Découvrez une sélection d’images du Fournier roux.
            </p>
        </div>

        <div class="galerie-vignettes">
            <button
                class="galerie-vignettes__nav galerie-vignettes__nav--prev"
                type="button"
                aria-label="Image précédente"
            >
                &#10094;
            </button>

            <div class="galerie-vignettes__track">
                <?php foreach ($galleryImages as $index => $image): ?>
                    <figure class="galerie-vignettes__item <?php echo $index === 0 ? 'galerie-vignettes__item--active' : ''; ?>">
                        <img
                            src="<?php echo htmlspecialchars($image['src']); ?>"
                            alt="<?php echo htmlspecialchars($image['alt']); ?>"
                            loading="lazy"
                        >
                    </figure>
                <?php endforeach; ?>
            </div>

            <button
                class="galerie-vignettes__nav galerie-vignettes__nav--next"
                type="button"
                aria-label="Image suivante"
            >
                &#10095;
            </button>
        </div>

        <div class="galerie-vignettes__dots" aria-label="Indicateurs de galerie">
            <?php foreach ($galleryImages as $index => $image): ?>
                <span class="galerie-vignettes__dot <?php echo $index === 0 ? 'galerie-vignettes__dot--active' : ''; ?>"></span>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- =========================
         SECTION VIDÉOS
         ========================= -->
    <section class="section-galerie">
        <div class="entete-section">
            <p class="entete-section__tag"></p>
            <h2>Observations vidéo</h2>
            <p>
                Plongez dans l’univers du Fournier roux à travers des vidéos révélant son comportement.
            </p>
        </div>

        <div class="grille-media grille-media--videos">
            <article class="carte-media carte-media--video">
                <div class="carte-media__visual">
                    <video controls playsinline preload="metadata">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux-audio.mp4" type="video/mp4">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux-audio.webm" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>

                <div class="carte-media__content">
                    <h3> Une première vidéo montrant le Fournier roux dans son environnement
                        avec son chant naturel.</h3>
                </div>
            </article>

            <article class="carte-media carte-media--video">
                <div class="carte-media__visual">
                    <video controls playsinline preload="metadata">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux1.webm" type="video/webm">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux1.mp4" type="video/mp4">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux.webm" type="video/webm">
                        <source src="<?php echo $assetBase; ?>/videos/fournier-roux.mp4" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>

                <div class="carte-media__content">
                    <h3>Nouvelle observation vidéo du Fournier roux : le père donne à manger à son petit.</h3>
                </div>
            </article>
        </div>
    </section>

    <!-- =========================
         SECTION AUDIO
         ========================= -->
    <section class="section-galerie">
        <div class="entete-section">
            <p class="entete-section__tag"></p>
            <h2>🎧 Écouter le Fournier roux</h2>
            <p>
                Une sélection d’enregistrements audio pour écouter le chant
                et l’ambiance sonore autour du Fournier roux.
            </p>
        </div>

        <div class="liste-audio" data-audio-playlist>
            <article class="carte-media carte-media--audio liste-audio__player-card">
                <div class="carte-media__content">
                    <audio controls preload="metadata" data-audio-player>
                        <source
                            src="<?php echo htmlspecialchars($audioTracks[0]['src']); ?>"
                            type="<?php echo htmlspecialchars($audioTracks[0]['type']); ?>"
                            data-audio-source
                        >
                        Votre navigateur ne supporte pas la lecture audio.
                    </audio>
                    <p data-audio-current-title>Rufous Hornero - Furnarius rufus</p>
                </div>
            </article>

            <div class="liste-audio__list" role="list" aria-label="Liste des audios">
                <?php foreach ($audioTracks as $index => $track): ?>
                    <button
                        type="button"
                        class="liste-audio__item <?php echo $index === 0 ? 'liste-audio__item--active' : ''; ?>"
                        data-audio-src="<?php echo htmlspecialchars($track['src']); ?>"
                        data-audio-type="<?php echo htmlspecialchars($track['type']); ?>"
                        aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    >
                        <span class="liste-audio__item-title"><?php echo htmlspecialchars($track['label']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- =========================
         SECTION D’APPEL À L’ACTION
         Lien vers les observations iNaturalist
         ========================= -->
    <section class="section-galerie section-galerie--cta">
        <div class="appel-galerie">
            <div class="appel-galerie__text">
                <p class="entete-section__tag"></p>
                <h2>Voir aussi les observations iNaturalist</h2>
                <p>
                    Complétez cette galerie avec les observations récentes publiées
                    via iNaturalist pour suivre l’actualité du Fournier roux.
                </p>
            </div>

            <div class="appel-galerie__action">
                <a class="bouton-primaire" href="index.php?page=inaturalist">
                    Voir les observations
                </a>
            </div>
        </div>
    </section>

</main>