let pageCourante = 1;
let chargementEnCours = false;
let toutesLesObservationsChargees = false;
const quantiteParGroupe = 6;

/*
  Renvoie la meilleure URL d'image disponible pour une photo iNaturalist.
  On privilégie l'URL principale, puis les variantes medium ou small,
  avant de forcer une version large quand c'est possible.
*/
function obtenirImage(photo) {
  if (!photo) return "";

  let image = photo.url || photo.medium_url || photo.small_url || "";

  if (!image) return "";

  image = image
    .replace("/square.", "/large.")
    .replace("/small.", "/large.")
    .replace("/medium.", "/large.");

  return image;
}

/*
  Affiche un groupe d'observations dans la zone principale.
  Si aucun résultat n'est disponible, le bouton de chargement est masqué.
*/
function afficherGroupe(groupe) {
  const liste = document.getElementById("observations-list");
  const bouton = document.getElementById("load-more-inat");

  if (!liste) return;

  if (!groupe || groupe.length === 0) {
    if (bouton) {
      bouton.style.display = "none";
    }
    return;
  }

  let html = '<div class="obs-grid">';

  for (let i = 0; i < groupe.length; i++) {
    const observation = groupe[i];

    const image =
      observation.photos && observation.photos.length > 0
        ? obtenirImage(observation.photos[0])
        : "";

    const date = observation.observed_on || "Date inconnue";
    const lieu = observation.place_guess || "Lieu inconnu";

    html += '<article class="obs-card">';

    if (image) {
      html += '<div class="obs-image-wrapper">';
      html +=
        '<img src="' +
        image +
        '" alt="Observation iNaturalist" loading="lazy" decoding="async" referrerpolicy="no-referrer">';
      html += '<span class="obs-credit">Source : iNaturalist &copy;</span>';
      html += "</div>";
    }

    html += "<p>Date : " + date + "</p>";
    html += "<p>Lieu : " + lieu + "</p>";
    html += "</article>";
  }

  html += "</div>";

  liste.innerHTML = html;
}

/*
  Interroge l'API iNaturalist pour charger un nouveau groupe d'observations.
  La fonction évite les requêtes en double et met à jour l'interface
  selon l'état du chargement, les résultats ou les erreurs éventuelles.
*/
function chargerINaturalist() {
  const liste = document.getElementById("observations-list");
  const bouton = document.getElementById("load-more-inat");

  if (!liste || chargementEnCours || toutesLesObservationsChargees) return;

  chargementEnCours = true;

  if (bouton) {
    bouton.disabled = true;
  }

  if (pageCourante === 1) {
    liste.innerHTML = "<p>Chargement...</p>";
  }

  fetch(
    "https://api.inaturalist.org/v1/observations?taxon_id=11275&photos=true&per_page=" +
      quantiteParGroupe +
      "&page=" +
      pageCourante +
      "&order_by=observed_on&order=desc"
  )
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Réponse HTTP invalide : " + response.status);
      }

      return response.json();
    })
    .then(function (data) {
      if (!data) {
        throw new Error("JSON vide");
      }

      if (!data.results || !Array.isArray(data.results)) {
        throw new Error("Format JSON invalide : 'results' manquant");
      }

      const nouvellesObservations = [];

      for (let i = 0; i < data.results.length; i++) {
        const observation = data.results[i];

        if (
          observation &&
          observation.photos &&
          observation.photos.length > 0
        ) {
          nouvellesObservations.push(observation);
        }
      }

      if (nouvellesObservations.length === 0) {
        if (pageCourante === 1) {
          liste.innerHTML = "<p>Aucune observation trouvée.</p>";
        }

        toutesLesObservationsChargees = true;

        if (bouton) {
          bouton.style.display = "none";
          bouton.disabled = false;
        }

        chargementEnCours = false;
        return;
      }

      afficherGroupe(nouvellesObservations);

      if (nouvellesObservations.length < quantiteParGroupe) {
        toutesLesObservationsChargees = true;

        if (bouton) {
          bouton.style.display = "none";
        }
      } else {
        pageCourante++;

        if (bouton) {
          bouton.style.display = "inline-block";
        }
      }

      if (bouton) {
        bouton.disabled = false;
      }

      chargementEnCours = false;
    })
    .catch(function (error) {
      console.error("Erreur iNaturalist :", error);

      if (pageCourante === 1) {
        liste.innerHTML = "<p>Erreur lors du chargement des observations.</p>";
      }

      if (bouton) {
        bouton.style.display = "none";
        bouton.disabled = false;
      }

      chargementEnCours = false;
    });
}

/*
  Initialise les composants principaux une fois le DOM prêt :
  chargement iNaturalist, galerie de miniatures et interactions utilisateur.
*/
document.addEventListener("DOMContentLoaded", function () {
  const liste = document.getElementById("observations-list");
  const bouton = document.getElementById("load-more-inat");

  if (liste) {
    chargerINaturalist();
  }

  if (bouton) {
    bouton.addEventListener("click", function () {
      chargerINaturalist();
    });
  }

  /* Gère la galerie de miniatures et la navigation entre les images. */
  const gallery = document.querySelector(".thumb-gallery");

  if (gallery) {
    const prevBtn = gallery.querySelector(".thumb-gallery__nav--prev");
    const nextBtn = gallery.querySelector(".thumb-gallery__nav--next");
    const items = gallery.querySelectorAll(".thumb-gallery__item");
    const dots = document.querySelectorAll(".thumb-gallery__dot");

    let indexActuel = 0;

    /*
      Met à jour l'élément actif, les indicateurs et le scroll
      afin de recentrer la miniature sélectionnée.
    */
    function mettreAJourGalerie(index) {
      if (!items.length) return;

      if (index < 0) {
        indexActuel = 0;
      } else if (index >= items.length) {
        indexActuel = items.length - 1;
      } else {
        indexActuel = index;
      }

      for (let i = 0; i < items.length; i++) {
        items[i].classList.remove("is-active");
      }

      for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("is-active");
      }

      items[indexActuel].classList.add("is-active");

      if (dots[indexActuel]) {
        dots[indexActuel].classList.add("is-active");
      }

      items[indexActuel].scrollIntoView({
        behavior: "smooth",
        inline: "center",
        block: "nearest"
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        if (indexActuel > 0) {
          mettreAJourGalerie(indexActuel - 1);
        }
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        if (indexActuel < items.length - 1) {
          mettreAJourGalerie(indexActuel + 1);
        }
      });
    }

    if (items.length > 0) {
      for (let i = 0; i < items.length; i++) {
        items[i].addEventListener("click", function () {
          mettreAJourGalerie(i);
        });
      }
    }

    if (dots.length > 0) {
      for (let i = 0; i < dots.length; i++) {
        dots[i].addEventListener("click", function () {
          mettreAJourGalerie(i);
        });
      }
    }

    mettreAJourGalerie(0);
  }
});

/* Gère la lightbox de la galerie principale de la page d'accueil. */
const lightbox = document.getElementById("custom-lightbox");
const lightboxImage = document.getElementById("lightbox-image");
const lightboxClose = document.getElementById("lightbox-close");
const lightboxPrev = document.getElementById("lightbox-prev");
const lightboxNext = document.getElementById("lightbox-next");
const galerieLiens = document.querySelectorAll(".accueil-galerie .paysage a");

if (
  lightbox &&
  lightboxImage &&
  lightboxClose &&
  lightboxPrev &&
  lightboxNext &&
  galerieLiens.length > 0
) {
  let imageActuelle = 0;

  /*
    Ouvre la lightbox avec l'image sélectionnée
    et bloque le scroll de la page pendant l'affichage.
  */
  function ouvrirLightbox(index) {
    const lien = galerieLiens[index];
    const image = lien.querySelector("img");

    if (!lien || !image) return;

    imageActuelle = index;
    lightboxImage.src = lien.getAttribute("href");
    lightboxImage.alt = image.getAttribute("alt");

    lightbox.classList.add("active");
    lightbox.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  }

  /* Ferme la lightbox et rétablit l'état normal de la page. */
  function fermerLightbox() {
    lightbox.classList.remove("active");
    lightbox.setAttribute("aria-hidden", "true");
    lightboxImage.src = "";
    lightboxImage.alt = "";
    document.body.style.overflow = "";
  }

  /* Passe à l'image suivante, avec retour au début en fin de galerie. */
  function imageSuivante() {
    imageActuelle++;

    if (imageActuelle >= galerieLiens.length) {
      imageActuelle = 0;
    }

    ouvrirLightbox(imageActuelle);
  }

  /* Revient à l'image précédente, avec boucle vers la fin si nécessaire. */
  function imagePrecedente() {
    imageActuelle--;

    if (imageActuelle < 0) {
      imageActuelle = galerieLiens.length - 1;
    }

    ouvrirLightbox(imageActuelle);
  }

  for (let i = 0; i < galerieLiens.length; i++) {
    galerieLiens[i].addEventListener("click", function (event) {
      event.preventDefault();
      ouvrirLightbox(i);
    });
  }

  lightboxClose.addEventListener("click", function () {
    fermerLightbox();
  });

  lightboxNext.addEventListener("click", function () {
    imageSuivante();
  });

  lightboxPrev.addEventListener("click", function () {
    imagePrecedente();
  });

  lightbox.addEventListener("click", function (event) {
    if (event.target === lightbox) {
      fermerLightbox();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (!lightbox.classList.contains("active")) return;

    if (event.key === "Escape") {
      fermerLightbox();
    }

    if (event.key === "ArrowRight") {
      imageSuivante();
    }

    if (event.key === "ArrowLeft") {
      imagePrecedente();
    }
  });
}

/* Gère le slider automatique de la section du nid. */
const nidSlider = document.querySelector(".nid-slider");

if (nidSlider) {
  const track = nidSlider.querySelector(".nid-slider__track");
  const slides = nidSlider.querySelectorAll(".nid-slider__slide");

  if (track && slides.length > 0) {
    const firstClone = slides[0].cloneNode(true);
    track.appendChild(firstClone);

    let currentIndex = 0;
    let slideWidth = slides[0].offsetWidth;

    /*
      Met à jour la position du slider.
      La transition peut être activée ou désactivée selon le contexte.
    */
    function updateNidSlider(withTransition) {
      if (withTransition) {
        track.style.transition = "transform 0.35s ease";
      } else {
        track.style.transition = "none";
      }

      track.style.transform =
        "translateX(-" + currentIndex * slideWidth + "px)";
    }

    /* Passe à la slide suivante. */
    function nextNidSlide() {
      currentIndex++;
      updateNidSlider(true);
    }

    track.addEventListener("transitionend", function () {
      if (currentIndex === slides.length) {
        currentIndex = 0;
        updateNidSlider(false);
      }
    });

    window.addEventListener("resize", function () {
      slideWidth = slides[0].offsetWidth;
      updateNidSlider(false);
    });

    setInterval(function () {
      nextNidSlide();
    }, 2500);

    updateNidSlider(false);
  }
}

/* Gère une playlist audio interactive. */
const playlist = document.querySelector("[data-audio-playlist]");

if (playlist) {
  const buttons = playlist.querySelectorAll(".audio-playlist__item");
  const audio = playlist.querySelector("[data-audio-player]");
  const source = playlist.querySelector("[data-audio-source]");

  if (buttons.length && audio && source) {
    buttons.forEach(function (button) {
      button.addEventListener("click", function () {
        const src = this.dataset.audioSrc;
        const type = this.dataset.audioType;

        buttons.forEach(function (item) {
          item.classList.remove("is-active");
          item.setAttribute("aria-pressed", "false");
        });

        this.classList.add("is-active");
        this.setAttribute("aria-pressed", "true");

        source.src = src;
        source.type = type;

        audio.pause();
        audio.load();
      });
    });
  }
}

/* Gère l'ouverture et la fermeture du menu burger. */
const burgerBtn = document.getElementById("burger-btn");
const mainNav = document.getElementById("main-nav");
const navLinks = document.querySelectorAll("#main-nav a");

if (burgerBtn && mainNav) {
  burgerBtn.addEventListener("click", function () {
    mainNav.classList.toggle("active");
  });
}

if (navLinks.length > 0) {
  for (let i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener("click", function () {
      if (mainNav) {
        mainNav.classList.remove("active");
      }
    });
  }
}

console.log("MAIN JS CHARGÉ");