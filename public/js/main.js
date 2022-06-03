let urlCommunes = "http://localhost/projet-symfony/animaux-perdus/public/api/communes/";
let urlSecteurs = "http://localhost/projet-symfony/animaux-perdus/public/api/secteurs/";


async function mounted() {
    if (document.getElementById('idSecteur')) {
        let idSecteur = document.getElementById('idSecteur').innerText
        this.selectedSecteur = await axios.get(urlSecteurs + idSecteur).then(res => res.data);
        this.secteurId = idSecteur;

    }
    ;
    this.communes = await axios.get(urlCommunes).then((res) => res.data);
    this.allSecteurs = await axios.get(urlSecteurs).then((res) => res.data);
    this.selectedSecteurs = this.allSecteurs;
}

const app = new Vue({
    el: "#app",
    data: {
        communes: null,
        allSecteurs: null,
        selectedSecteur: null,
        selectedSecteurs: null,
        selectedCommune: null,
        secteurId: null,
        newSecteur: {
            nom: null,
            adresse: null,
            latitude: null,
            longitude: null,
            commune: null
        }
    },
    mounted,
    methods: {
        log(secteur) {
            this.secteurId = secteur.id;
            this.selectedSecteur = secteur;
            console.log(secteur);
        },
        filter(commune) {
            this.selectedSecteurs = this.allSecteurs.filter(function (c) {
                if (c.commune.id == commune.id) {
                    return c;
                }
            });
        },
        postSecteur() {
            console.log(this.newSecteur);
            axios.post(urlSecteurs, this.newSecteur).then(res => this.allSecteurs.push(res.data));
        },
        test() {
            console.log(this.secteurId);
        }
    },
});
