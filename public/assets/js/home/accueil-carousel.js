(() => {
  "use strict";

  // =========================
  // INITIALISATION
  // =========================
  const carousel = document.getElementById("desktopCarousel");
  if (!carousel) return;

  const slides = carousel.querySelectorAll(".desktop-carousel__slide");
  const prevBtn = carousel.querySelector(".desktop-carousel__btn--prev");
  const nextBtn = carousel.querySelector(".desktop-carousel__btn--next");

  if (!slides.length || !prevBtn || !nextBtn) return;

  let currentIndex = 0;
  let autoPlayInterval = null;

  // =========================
  // AFFICHAGE D'UNE SLIDE
  // =========================
  function showSlide(index) {
    slides.forEach((slide) => {
      slide.classList.remove("is-active");
    });

    slides[index].classList.add("is-active");
  }

  // =========================
  // NAVIGATION
  // =========================
  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  }

  // =========================
  // AUTOPLAY
  // =========================
  function startAutoPlay() {
    stopAutoPlay();
    autoPlayInterval = window.setInterval(nextSlide, 4000);
  }

  function stopAutoPlay() {
    if (autoPlayInterval) {
      window.clearInterval(autoPlayInterval);
      autoPlayInterval = null;
    }
  }

  // =========================
  // EVENTS CLICK (SOURIS)
  // =========================
  nextBtn.addEventListener("click", () => {
    nextSlide();
    startAutoPlay();
  });

  prevBtn.addEventListener("click", () => {
    prevSlide();
    startAutoPlay();
  });

  // =========================
  // EVENTS CLAVIER (ACCESSIBILITÉ)
  // Permet navigation avec flèches ← →
  // =========================
  document.addEventListener("keydown", (e) => {
    // seulement si le carousel est visible dans la page
    if (!carousel.contains(document.activeElement)) return;

    if (e.key === "ArrowRight") {
      nextSlide();
      startAutoPlay();
    }

    if (e.key === "ArrowLeft") {
      prevSlide();
      startAutoPlay();
    }
  });

  // =========================
  // PAUSE AU SURVOL
  // =========================
  carousel.addEventListener("mouseenter", () => {
    stopAutoPlay();
  });

  carousel.addEventListener("mouseleave", () => {
    startAutoPlay();
  });

  // =========================
  // INIT
  // =========================
  showSlide(currentIndex);
  startAutoPlay();
})();