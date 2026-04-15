/* Gère une playlist audio interactive. */
const playlist = document.querySelector("[data-audio-playlist]");

if (playlist) {
  const buttons = playlist.querySelectorAll(".liste-audio__item");
  const audio = playlist.querySelector("[data-audio-player]");
  const source = playlist.querySelector("[data-audio-source]");

  if (buttons.length > 0 && audio && source) {
    buttons.forEach(function (button) {
      button.addEventListener("click", function () {
        const src = this.dataset.audioSrc;
        const type = this.dataset.audioType;

        buttons.forEach(function (item) {
          item.classList.remove("liste-audio__item--active");
          item.setAttribute("aria-pressed", "false");
        });

        this.classList.add("liste-audio__item--active");
        this.setAttribute("aria-pressed", "true");

        source.src = src;
        source.type = type;

        audio.pause();
        audio.load();
      });
    });
  }
}