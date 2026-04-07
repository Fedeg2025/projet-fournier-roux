<?php

$galleryWebPath = 'public/assets/images/nid';

$images = [
    'nid1.webp',
    'nid3.webp',
    'nid4.webp',
    'img4.5.webp',
    'nid5.webp',
    'nid6.webp',
    'nid7.webp',
    'nid8.webp',
    'nid9.webp',
    'nid10.webp',
    'nid11.webp',
    'nid12.webp',
    'nid14.webp',
    'nid15.webp',
    'img16.webp',
    'img17.webp',
    'nid18.webp',
    'nid20.webp',
    'nid21.webp',
    'nid22.webp',
    'nid23.webp',
    'nid24.webp',
    'nid25.webp',
    'nid26.webp',
    'nid27.webp',
    'nid28.webp',
    'nid29.webp',
    'nid30.webp',
    'nid31.webp',
    'nid32.webp',
    'nid33.webp',
    'nid34.webp',
    'img2.webp'
];

?>

<main id="main-content" class="page-nid">
    <article class="contenu-page">

        <header class="entete">
            <h1>Construction du nid du fournier roux</h1>
        </header>

        <section class="image-principale">
            <figure class="figure-nid">
                <img
                    src="<?= $galleryWebPath; ?>/nid8.webp"
                    alt="Fournier roux devant son nid"
                >
            </figure>
        </section>

        <section class="carte">
            <h2>Comment le fournier construit son nid</h2>

            <p>
                Le fournier roux (<em>Furnarius rufus</em>) est célèbre pour son nid en forme de petit four en argile.
                Cette structure solide et originale est l’une des constructions les plus remarquables du monde des oiseaux.
            </p>

            <p>
                La construction se fait progressivement en plusieurs étapes. Les oiseaux commencent par déposer une base
                de boue humide mélangée à des fibres végétales, qu’ils façonnent en couches pour former la structure.
                Ensuite, ils élèvent les parois et créent un tunnel d’entrée latéral caractéristique.
            </p>

            <p>
                La chambre interne est ensuite tapissée de matériaux plus doux, comme des plumes et des fibres végétales,
                afin d’assurer une bonne isolation thermique et de protéger les œufs ainsi que les poussins.
            </p>
        </section>

        <!-- SLIDER NUEVO -->
        <section id="galerie-nid" class="section section-galerie">
            <h2>L’incroyable processus de construction du nid</h2>

            <div class="nid-slider">
                <div class="nid-slider__track">
                    <?php foreach ($images as $index => $fileName): ?>
                        <?php $imageUrl = $galleryWebPath . '/' . $fileName; ?>

                        <div class="nid-slider__slide">
                            <img
                                src="<?= $imageUrl; ?>"
                                alt="Étape <?= $index + 1; ?> de la construction du nid"
                                loading="lazy"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section processus">
            <div class="cartes">

                <article class="carte">
                    <h3>Durée et construction</h3>

                    <p>
                        Chaque couche doit sécher avant d’ajouter la suivante, ce qui donne au final une construction
                        très solide et résistante.
                    </p>

                    <p>
                        En général, le fournier peut construire son nid en environ 15 jours, mais la durée varie selon
                        les conditions. Dans certains cas, la construction peut prendre plusieurs semaines, voire plusieurs mois.
                    </p>

                    <p>
                        Cette variation dépend du climat, de la disponibilité de la boue et des matériaux.
                        Si la boue est trop sèche, la construction devient plus difficile. Si elle est trop humide,
                        les oiseaux doivent attendre qu’elle sèche.
                    </p>
                </article>

                <article class="carte">
                    <h3>Particularités du nid</h3>

                    <p>
                        Le nid du fournier est considéré comme unique parmi les oiseaux grâce à sa forme et à sa technique
                        de construction. Contrairement à de nombreuses espèces qui utilisent uniquement des branches ou des fibres végétales,
                        le fournier construit une structure en argile durcie, ressemblant à un petit four en adobe.
                    </p>

                    <p>
                        Ses caractéristiques principales sont :
                    </p>

                    <p>
                        des parois épaisses et résistantes,<br>
                        une entrée courbée en spirale,<br>
                        une chambre interne protégée.
                    </p>

                    <p>
                        Cette architecture protège efficacement contre la pluie, le vent, les prédateurs et les variations de température.
                        Son originalité a attiré l’attention des scientifiques et des observateurs de la nature depuis longtemps.
                    </p>

                    <p>
                        Une fois construit, le nid peut durer plusieurs années. La boue mélangée à des fibres végétales devient très solide après séchage.
                        Même si le couple construit généralement un nouveau nid à chaque saison de reproduction, les anciens restent souvent intacts pendant longtemps.
                    </p>

                    <p>
                        Grâce à cette résistance, le nid du fournier est souvent considéré comme une véritable œuvre d’architecture naturelle.
                    </p>

                    <p>
                        Le fournier ne réutilise généralement pas le même nid pour sa reproduction.
                        À chaque saison, il construit un nouveau nid, souvent près du précédent, surtout si l’endroit offre de bonnes conditions pour élever les petits.
                    </p>

                    <p>
                        Après l’abandon du nid par les fourniers, d’autres animaux peuvent l’utiliser comme refuge.
                        Parmi les visiteurs fréquents, on trouve des tordos, des hirondelles, des martinets et de petites chouettes.
                        Certains reptiles et insectes peuvent également occuper les cavités du nid sec.
                    </p>
                </article>

            </div>
        </section>

    </article>
</main>