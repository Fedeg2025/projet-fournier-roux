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

  function fermerLightbox() {
    lightbox.classList.remove("active");
    lightbox.setAttribute("aria-hidden", "true");
    lightboxImage.src = "";
    lightboxImage.alt = "";
    document.body.style.overflow = "";
  }

  function imageSuivante() {
    imageActuelle++;

    if (imageActuelle >= galerieLiens.length) {
      imageActuelle = 0;
    }

    ouvrirLightbox(imageActuelle);
  }

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