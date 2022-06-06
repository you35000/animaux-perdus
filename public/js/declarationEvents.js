const getCommunes = function (e) {

    //récupération de l'url d'appel et de la valeur du code postal
    let url = $(this).data('url');
    let codePostal = $(this).val();

    //Fetch ajax
    fetch(url, {method: 'POST', body: JSON.stringify({"codepostal": codePostal})})
        .then(function (response) {
            return response.json()
        }).then(function (data) {

        //on vide le select
        $('#secteur_commune').empty();

        //on y ajout les communes récupérées en fonction du code postal
        if (data.length > 0) {
            let options = '';

            $.each(data, function (idx, val) {
                options += "<option value='" + val.id + "'>" + val.nom + "</option>";
            });
            $('#secteur_commune').append(options);
        }
        syncCommuneSelect();
    });
}

const getSecteur = function (e) {

    //récupération des données
    let adresse = $('#secteur_adresse').val();
    let communes = $('#secteur_communes').val();
    let url = $('#secteur_communes').data('url');

    //Fetch ajax pour mise à jour de l'adresse, latitude et longitude
    fetch(url, {method: 'POST', body: JSON.stringify({"adresse": adresse, 'commune': communes})})
        .then(function (response) {
            return response.json()
        }).then(function (data) {

        $('#secteur_latitude').val(data.lat);
        $('#secteur_longitude').val(data.lng);
        $('#secteur_adresse').val(data.adresse);
    });

}

const createSecteur = function (e) {
    e.preventDefault();

    //test si champs required vides ou pas
    let required = true;
    $(".modal-body [required]").each(function (idx, elem) {
        if ($(elem).val().trim() == '') {
            required = false;
        }
    });
    if (!required) {
        document.querySelector('#secteurForm').reportValidity();
        return false;
    }

    //récupération de l'url
    let url = $('#secteurForm').attr('action');
    //création d'un objet FormData pour soumettre le form en ajax
    let formData = new FormData(document.querySelector("#secteurForm"));

    fetch(url, {method: 'POST', body: formData})
        .then(function (response) {
            return response.text();
        }).then(function (data) {

        //test pour parser en json la réponse si c'est bon c'est qu'on récupère bien notre secteur
        //sinon c'est que le formulaire n'est pas valide
        try {
            data = JSON.parse(data);
            //ajout du secteur nouvellement créé à la liste de base en le sélectionnant
            $('#declaration_secteur').append("<option value='" + data.id + "' selected>" + data.nom + "</option>");
            $('#secteurModal').modal('hide');

        } catch (e) {
            $('.modal-body').empty();
            $('.modal-body').append(data);
            //ajout des events sur les boutons, vu que l'on a remplacé tout le body de la modal
            $('#secteur_codePostal').on('keyup', delay(getCommunes, 500));
            $('#searchCoord').on('click', getSecteur);
        }

    });

}

const getSecteurs = function (e) {

    let url = $(this).data('url');
    let commune = $(this).val();

    //récupère les secteurs par rapport à la commune
    fetch(url, {method: 'POST', body: JSON.stringify({'commune': commune})})
        .then(function (response) {
            return response.json();
        }).then(function (data) {
        //on vide le select et on rajoute les secteurs spécifiques au secteur
        $('#declaration_secteur').empty();
        $.each(data, function (idx, val) {
            $('#declaration_secteur').append('<option value="' + val.id + '">' + val.nom + '</option>')
        })
    })
}


const syncCommuneSelect = function (){

    let id = $('#secteur_commune').val();
    $('#declaration_commune').val(id);
    init();


}

//ajout des events sur les boutons
$('#secteur_codePostal').on('keyup', delay(getCommunes, 500));
$('#searchCoord').on('click', getSecteur());
$('#secteurCreate').on('click', createSecteur);
$('#secteur_commune').on('change', syncCommuneSelect);

$('#declaration_commune').on('change', getSecteurs);


//méthode permettant de ne pas lancer tout de suite un évenement
function delay(fn, ms) {
    let timer = 0
    return function (...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}


const init = function () {
    //$('#declaration_commune').trigger('change');
}

window.onload = init;