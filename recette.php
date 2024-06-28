<?php
require_once('./config.php');

//si l'utilisateur est deja connecter, ne pas demander la connexion a chaque fois, une seule suffie.
if( !  isset($_SESSION["user_loggedin"]) ){
  header("Location: login.php");
  exit();
}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./normalize.css" />
    <link rel="stylesheet" href="./styles.css" />
    <script src="script.js?id=10"></script>

    <title>Your Title Here</title>
  </head>
  <body>
    <header>
      <div class="Container-titre">
        <h1>L'ÉTS a du goût</h1>
      </div>
      <div class="Container-filtre">
        <h2>Filtres</h2>
        <p>Type de plat:</p>
        <select class="Selector" name="Tous" id="Tous">
        <option value="" selected>Tous</option>
            <?php
            $types_plats = liste_types_plats($conn);
            $longueur_tab = count($types_plats);
            for($i=0; $i<$longueur_tab;$i++)
            {
              $nom = $types_plats[$i]['nom'];
              echo "<option value=\"" . $types_plats[$i]['nom'] . "\">$nom</option>";    
            }
            ?>
        </select>
        <p>Type de cuisine:</p>
        <select class="Selector" name="Toutes" id="Toutes">
        <option value=""  selected>Toutes</option>
           <?php
            $types_cuisine = liste_types_cuisines($conn);
            $longueur_tab = count($types_cuisine);
            for($i=0; $i<$longueur_tab;$i++)
            {
              $nom = $types_cuisine[$i]['nom'];
              echo "<option value=\"" . $types_cuisine[$i]['nom'] . "\" >$nom</option>";    
            }
            ?>
        </select>
        <div class="recherhe">
          <input
            type="text"
            id="searchField"
            name="search"
            placeholder="Rechercher..."
          />
          <button type="button" id="searchButton">Chercher</button>
        </div>
      </div>
    </header>

    <main class="container-recette">
      <h2 class="titre" id="titre_recette"></h2>
      <div class="recipe-info">
        <div>
          <img
            src="./images_recette/burgers.jpg"
            alt="Burger sur la planche"
            class="image400px"
          />
        </div>
        <div class="details">
          <div class="info-section">
            <img src="./images_recette/clock.png" alt="" class="serve-icon" />
            <h3>Temps de préparation:</h3>
            <p id="tps_prep"></p>
          </div>

          <div class="info-section">
            <img
              src="./images_recette/Knife-fork.jpg"
              alt=""
              class="serve-icon"
            />
            <h3>Type de plat:</h3>
            <p id="type_plat"></p>
          </div>

          <div class="info-section">
            <img
              src="./images_recette/serve-icon.png"
              alt=""
              class="serve-icon"
            />
            <h3>Type de cuisine:</h3>
            <p id="type_cuisine"></p>
          </div>
        </div>
      </div>

      <table>
        <h4>Liste d'ingrédients</h4>
        <thead>
          <tr>
            <th>Nom de l'ingrédient</th>
            <th>Quantité (Unité/cuillères)</th>
            <th>Quantité (grammes/ml)</th>
          </tr>
        </thead>
        <tbody class="body_table"></tbody>
      </table>
      <h4>Étape de préparation de la recette</h4>
      <ol class="liste"></ol>
    </main>
    <footer>
      <p>© 2024 Recettes de cuisine. Tous droits réservés.</p>
      <p>Auteurs: Amine El Hila & Aya Rehimi</p>
    </footer>
  </body>
  <script>


    types_plats = <?= json_encode($types_plats) ?> ; 
    types_cuisines= <?= json_encode($types_cuisine)  ?>;

    document.addEventListener("DOMContentLoaded", (event) => {

       const urlParams = new URLSearchParams(window.location.search);
       const recetteId = parseInt(urlParams.get("id"));



      fetch("/api/recettes/"+recetteId)
        .then(response=>{
            if(!response.ok) throw new Error("Impossible de charger...");

            return response.json();
        })
        .then( data=>{
    
            afficher_recette(data);
        } )
        .catch(error=>{
            alert(error.message);
        } )
       



    });
  </script>
</html>
