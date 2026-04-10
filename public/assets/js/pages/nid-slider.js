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