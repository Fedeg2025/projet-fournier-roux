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
});