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