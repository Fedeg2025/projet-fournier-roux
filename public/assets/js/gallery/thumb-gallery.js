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