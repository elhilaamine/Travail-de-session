const afficher_resume_recette = (une_recette) => {

    const image = document.createElement('img');
    image.src = une_recette.image_url;

    const titre = document.createElement('h3');
    titre.textContent = une_recette.titre;

    const descr = document.createElement('p');
     descr.textContent = une_recette.desc_courte;

    const carte = document.createElement('article');
    
    carte.append(image, titre, descr);

    carte.addEventListener("click", (event) =>{

        document.location.href = './recette.php?id='+ une_recette.id;
    
    });

    return carte;
}

const afficher_toutes_recettes = (tabCarte) => {
     
    const conteneur = document.querySelector(".Container-articles");

    
    for(let i=0; i<tabCarte.length; i++) {

        const nouvelElt = afficher_resume_recette(tabCarte[i]);
        conteneur.append(nouvelElt);

    }
    

        
 }


// const creer_options_header = (tabTypeCuisine, tabTypePlats) => { 

//     for(let i=0; i<tabTypePlats.length; i++) { 

//     const optionPlats = document.createElement('option');
//     optionPlats.textContent = tabTypePlats[i].nom;
//     }

//     for(let i=0; i<tabTypeCuisine.length; i++) { 

//         const optionCuisines = document.createElement('option');
//         optionCuisines.textContent = tabTypeCuisine[i].nom;
//         }
//     }

    function chercherTypeDePlat(typeDePlatId) {
        const typePlat = types_plats.find(plat => plat.id === typeDePlatId);
        return typePlat ? typePlat.nom : 'Type de plat inconnu';
      }

      function chercherTypeDeCuisine(typeDeCuisineId) {
        const typeDeCuisine = types_cuisines.find(plat => plat.id === typeDeCuisineId);
        return typeDeCuisine ? typeDeCuisine.nom : 'Type de plat inconnu';
      }

const afficher_recette = (une_recette) => {

    const mon_titre = document.querySelector('h2#titre_recette');
    mon_titre.textContent = une_recette.titre;

    const image = document.querySelector('img');
    image.src = une_recette.image_url;

    const tps_prep = document.querySelector('p#tps_prep');
    tps_prep.textContent = une_recette.temps_de_preparation;

    const type_plat = document.querySelector('p#type_plat');
    type_plat.textContent = chercherTypeDePlat(une_recette.type_de_plat); 

    const type_cuisine = document.querySelector('p#type_cuisine');
     type_cuisine.textContent = chercherTypeDeCuisine(une_recette.type_de_cuisine);  
    
    for(let i = 0; i<une_recette.ingredients.length; i++){

        const row = document.createElement('tr');
        row.id = 'ingredient-row-' + i;

        const case1 = document.createElement('td');
        case1.textContent = une_recette.ingredients[i].nom;
        row.appendChild(case1);

        const case2 = document.createElement('td');
        case2.textContent = une_recette.ingredients[i].quantite;
        row.appendChild(case2);

        const case3 = document.createElement('td');
        case3.textContent = une_recette.ingredients[i].quantite_equivalente;
        row.appendChild(case3);

        const conteneur = document.querySelector(".body_table");
        conteneur.appendChild(row);
    }

    for(let i = 0; i<une_recette.etapes_de_preparation.length; i++){

        const elt = document.createElement('li');
        elt.textContent = une_recette.etapes_de_preparation[i].etape;
        
        const conteneur1 = document.querySelector(".liste");
        conteneur1.appendChild(elt);
    }
        
    //return page;
}