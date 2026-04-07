<?php
$assetBase = '/web/fournier_roux/public/assets/images';

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
        'label' => 'track 1'
    ],
    [
        'src' => $assetBase . '/audios/XC943374%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.mp3',
        'type' => 'audio/mpeg',
        'label' => 'track 2'
    ],
    [
        'src' => $assetBase . '/audios/XC985697%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'track 3'
    ],
    [
        'src' => $assetBase . '/audios/XC992354%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'track 4'
    ],
    [
        'src' => $assetBase . '/audios/XC1009595%20-%20Rufous%20Hornero%20-%20Furnarius%20rufus.wav',
        'type' => 'audio/wav',
        'label' => 'track 5'
    ],
];
?>

<main class="gallery-page">

    <section class="gallery-hero">
        <div class="gallery-hero__content">
            <p class="gallery-hero__tag">Galerie multimédia</p>
            <h1>Galerie du <span>Fournier roux</span></h1>
            <p class="gallery-hero__text">
                Découvrez les vidéos et les enregistrements audio du Fournier roux
                dans une présentation immersive inspirée de la maquette Figma.
            </p>
        </div>
    </section>

    <section class="gallery-section">
        <div class="section-heading">
            <p class="section-heading__tag">Photos</p>
            <h2>Galerie photo</h2>
            <p>
                Découvrez une sélection d’images du Fournier roux
                dans une galerie horizontale inspirée de la maquette.
            </p>
        </div>

        <div class="thumb-gallery">
            <button class="thumb-gallery__nav thumb-gallery__nav--prev" type="button" aria-label="Image précédente">
                &#10094;
            </button>

            <div class="thumb-gallery__track">
                <?php foreach ($galleryImages as $index => $image): ?>
                    <figure class="thumb-gallery__item <?= $index === 0 ? 'is-active' : ''; ?>">
                        <img
                            src="<?= htmlspecialchars($image['src']); ?>"
                            alt="<?= htmlspecialchars($image['alt']); ?>"
                            loading="lazy"
                        >
                    </figure>
                <?php endforeach; ?>
            </div>

            <button class="thumb-gallery__nav thumb-gallery__nav--next" type="button" aria-label="Image suivante">
                &#10095;
            </button>
        </div>

        <div class="thumb-gallery__dots" aria-label="Indicateurs de galerie">
            <?php foreach ($galleryImages as $index => $image): ?>
                <span class="thumb-gallery__dot <?= $index === 0 ? 'is-active' : ''; ?>"></span>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="gallery-section">
        <div class="section-heading">
            <p class="section-heading__tag">Vidéos</p>
            <h2> Observations vidéo</h2>
            <p>
                Retrouvez ici plusieurs vidéos locales intégrées dans la galerie
                pour présenter le Fournier roux et son comportement.
            </p>
        </div>

        <div class="media-grid media-grid--videos">
            <article class="media-card media-card--video">
                <div class="media-card__visual">
                    <video controls playsinline preload="metadata">
                        <source src="<?= $assetBase; ?>/videos/fournier-roux-audio.mp4" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>

                <div class="media-card__content">
                    <h3>Vidéo 1 — Fournier roux avec chant naturel</h3>
                    <p>
                        Une première vidéo montrant le Fournier roux dans son environnement
                        avec son chant naturel.
                    </p>
                </div>
            </article>

            <article class="media-card media-card--video">
                <div class="media-card__visual">
                    <video controls playsinline preload="metadata">
                        <source src="<?= $assetBase; ?>/videos/fournier-roux1.webm" type="video/webm">
                        <source src="<?= $assetBase; ?>/videos/fournier-roux.webm" type="video/webm">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>

                <div class="media-card__content">
                    <h3>Vidéo 2 — Observation du Fournier roux</h3>
                    <p>
                        Une seconde observation vidéo des Fournier ou aparentement le male donne a manger au female.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <section class="gallery-section">
        <div class="section-heading">
            <p class="section-heading__tag">Audios</p>
            <h2>🎧 Écouter le Fournier roux</h2>
            <p>
                Une sélection d’enregistrements audio pour écouter le chant
                et l’ambiance sonore autour du Fournier roux.
            </p>
        </div>

        <div class="audio-playlist" data-audio-playlist>
            <article class="media-card media-card--audio audio-playlist__player-card">
                <div class="media-card__content">
                    <audio controls preload="metadata" data-audio-player>
                        <source
                            src="<?= htmlspecialchars($audioTracks[0]['src']); ?>"
                            type="<?= htmlspecialchars($audioTracks[0]['type']); ?>"
                            data-audio-source
                        >
                        Votre navigateur ne supporte pas la lecture audio.
                    </audio>
                    <p data-audio-current-title>Rufous Hornero - Furnarius rufus</p>
                </div>
            </article>

            <div class="audio-playlist__list" role="list" aria-label="Liste des audios">
                <?php foreach ($audioTracks as $index => $track): ?>
                    <button
                        type="button"
                        class="audio-playlist__item <?= $index === 0 ? 'is-active' : ''; ?>"
                        data-audio-src="<?= htmlspecialchars($track['src']); ?>"
                        data-audio-type="<?= htmlspecialchars($track['type']); ?>"
                        aria-pressed="<?= $index === 0 ? 'true' : 'false'; ?>"
                    >
                        <span class="audio-playlist__item-title"><?= htmlspecialchars($track['label']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="gallery-section gallery-section--cta">
        <div class="gallery-cta">
            <div class="gallery-cta__text">
                <p class="section-heading__tag">Données</p>
                <h2>Voir aussi les observations iNaturalist</h2>
                <p>
                    Complétez cette galerie avec les observations récentes publiées
                    via iNaturalist pour suivre l’actualité du Fournier roux.
                </p>
            </div>

            <div class="gallery-cta__action">
                <a class="btn-primary" href="index.php?page=inaturalist">
                    Voir les observations iNaturalist
                </a>
            </div>
        </div>
    </section>

</main>

