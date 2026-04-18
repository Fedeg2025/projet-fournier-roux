// =========================
// FORMULAIRE ADMIN ARTICLE
// Crée les champs alt automatiquement
// =========================

document.addEventListener('DOMContentLoaded', function () {

    let images = document.getElementById('images');
    let zoneAlt = document.getElementById('formulaire-article-admin-alts');

    if (images && zoneAlt) {

        images.addEventListener('change', function () {

            zoneAlt.innerHTML = '';

            let fichiers = images.files;

            for (let i = 0; i < fichiers.length; i++) {

                let bloc = document.createElement('div');

                let label = document.createElement('label');
                label.textContent = 'Texte alternatif pour : ' + fichiers[i].name;
                label.setAttribute('for', 'alt_' + i);
                label.className = 'formulaire-article-admin__label';

                let input = document.createElement('input');
                input.type = 'text';
                input.name = 'alt_texts[]';
                input.id = 'alt_' + i;
                input.className = 'formulaire-article-admin__input';
                input.maxLength = 255;

                bloc.className = 'formulaire-article-admin__alt-item';

                bloc.appendChild(label);
                bloc.appendChild(input);

                zoneAlt.appendChild(bloc);
            }

        });

    }

});