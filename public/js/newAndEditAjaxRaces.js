// Selection des diffèrents champs à manipuler (la liste des espèces et la liste des races)
let getCurrentEspeces = document.querySelector('#animal_form_especes');
let selectList = document.querySelector("#animal_form_races");

// l'url permettant d'accèder aux données via la base de données
let url = "/annonce/ajax/races";

getCurrentEspeces.addEventListener('change', (e) => {
    // e: l'event
    // target: l'element ciblé par l'event
    // value : la valeur stocké dans l'élement ciblé par l'event
    let value = e.target.value;

    // L'index actuellement selectionné dans le target
    // Si l'option selectionné est sur 0, à savoir tout sauf nos espèces ...
    if (e.target.selectedIndex === 0) {

        // on retire les champs potentiellement pésents dans le champs race
        removeAllChilds();

        // on remet l'option par defaut, qui demande à l'utilisateur de d'abord choisir son espèce
        let option = createOption(1, "Veuillez d'abord choisir une éspèce ...");

        // on ajoute ce champs au parent, à savoir, à la liste de choix
        selectList.appendChild(option);
    } else {
        // On lance un requète ajax pour obtenir les races correspondantes à l'espèce en cours de selection
        getRaces(url, value);
    }
})

function getRaces(url, value) {
    // On utilise la méthode POST, car on doit envoyer une donnée qui sera ensuite traité côté back-end
    // On ajoute cette donnée JSON dans le body
    // Si la promesse est tenue, on récupère les données, qu'on injecte dans la variable datas
    fetch(url, {
        method: "POST",
        body: JSON.stringify({"id": value})
    }).then(
        response => response.json()
    ).then(datas => {

        // On purge les options déja présentes, pour éviter d'avoir des doublons générés à l'infini
        removeAllChilds();
        let len = datas.length;

        // On balaye les datas pour ajouter une option par instance
        for (let i = 0; i < len; i++) {

            // On pointe sur l'instance en cours dans le tableau
            let current = datas[i];

            // On génère l'option qui sera ensuite ajouté dans la liste
            let option = createOption(current['id'], current['nom']);

            selectList.appendChild(option);
        }
    })
}

// Fonction permettant de supprimer tout les enfants d'un element
function removeAllChilds() {
    while (selectList.firstChild) {
        selectList.removeChild(selectList.lastChild);
    }
}

// Fonction permettant de créer une option, et de la retourner
function createOption(value, text) {
    let option = document.createElement('option');
    option.value = value;
    option.text = text;

    return option;
}