document.addEventListener('DOMContentLoaded', () => {
  const boutonRetourHaut = document.querySelector('.bouton-retour-haut');

  if (!boutonRetourHaut) return;

  const STEP = 700;

  boutonRetourHaut.addEventListener('click', (event) => {
    event.preventDefault();
    boutonRetourHaut.blur();

    const currentY =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop ||
      0;

    const nextY = Math.max(0, currentY - STEP);

    window.scrollTo(0, nextY);
    document.documentElement.scrollTop = nextY;
    document.body.scrollTop = nextY;
  });
});
document.addEventListener('DOMContentLoaded', () => {
  const boutonRetourHaut = document.querySelector('.bouton-retour-haut');

  if (!boutonRetourHaut) return;

  const STEP = 700;

  boutonRetourHaut.addEventListener('click', (event) => {
    event.preventDefault();
    boutonRetourHaut.blur();

    const currentY =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop ||
      0;

    const nextY = currentY <= STEP ? 0 : currentY - STEP;

    window.scrollTo(0, nextY);
    document.documentElement.scrollTop = nextY;
    document.body.scrollTop = nextY;
  });
});