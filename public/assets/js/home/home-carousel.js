(() => {
  "use strict";

  const carousel = document.getElementById("desktopCarousel");
  if (!carousel) return;

  const slides = carousel.querySelectorAll(".desktop-carousel__slide");
  const prevBtn = carousel.querySelector(".desktop-carousel__btn--prev");
  const nextBtn = carousel.querySelector(".desktop-carousel__btn--next");

  if (!slides.length || !prevBtn || !nextBtn) return;

  let currentIndex = 0;
  let autoPlayInterval = null;

  function showSlide(index) {
    slides.forEach((slide) => {
      slide.classList.remove("is-active");
    });

    slides[index].classList.add("is-active");
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  }

  function startAutoPlay() {
    stopAutoPlay();
    autoPlayInterval = window.setInterval(nextSlide, 4000);
  }

  function stopAutoPlay() {
    if (autoPlayInterval) {
      clearInterval(autoPlayInterval);
      autoPlayInterval = null;
    }
  }

  prevBtn.addEventListener("click", () => {
    prevSlide();
    startAutoPlay();
  });

  nextBtn.addEventListener("click", () => {
    nextSlide();
    startAutoPlay();
  });

  carousel.addEventListener("mouseenter", stopAutoPlay);
  carousel.addEventListener("mouseleave", startAutoPlay);

  showSlide(currentIndex);
  startAutoPlay();
})();