<?php
require_once('./config.php');


// Vérification de la déconnexion
if (isset($_GET['logout'])) {
    unset($_SESSION["user_loggedin"]);
    session_destroy();
    header("Location: login.php");
    exit();
}

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION["user_loggedin"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil</title>
    <link rel="stylesheet" href="./normalize.css" />
    <link rel="stylesheet" href="./styles.css" />
    <!-- <script src="data.js"></script> -->
    <script src="script.js"></script>
</head>


<body>
    <div class="Grid">
        <header>
            <div class="Container-titre">
                <h1>L'ÉTS a du goût</h1>
                <p class="bienvenue-text">
                    Bienvenue <?php echo htmlspecialchars($_SESSION["user_loggedin"]); ?>
                </p>
                <a href="index.php?logout=true" class="btn btn-decon">Se déconnecter</a>
            </div>
            <div class="Container-filtre">
                <h2>Filtres</h2>
                <p>Type de plat:</p>
                <select class="Selector" name="type_plat" id="plat">
                    <option value="all" selected>Tous</option>
                    <?php
                    $types_plats = liste_types_plats($conn);
                    $longueur_tab = count($types_plats);
                    for ($i = 0; $i < $longueur_tab; $i++) {
                        $nom = htmlspecialchars($types_plats[$i]['nom']);
                        echo "<option value=\"".$types_plats[$i]['id']."\">$nom</option>";
                    }

                    ?>
                </select>
                <p>Type de cuisine:</p>
                <select class="Selector" name="type_cuisine" id="cuisine">
                    <option value="" selected>Toutes</option>
                    <?php
                    $types_cuisine = liste_types_cuisines($conn);
                    $longueur_tab = count($types_cuisine);
                    for ($i = 0; $i < $longueur_tab; $i++) {
                        $nom = htmlspecialchars($types_cuisine[$i]['nom']);
                        echo "<option value=\"".$types_cuisine[$i]['id']."\">$nom</option>";
                    }

                    ?>
                </select>
                <div class="recherhe">
                    <input type="text" id="searchField" name="search" placeholder="Rechercher..." />
                    <button type="button" id="searchButton">Chercher</button>
                </div>
            </div>
        </header>
        <main>
            <div class="Container-articles" id="main"></div>
        </main>
        <footer>
            <p>© 2024 Recettes de cuisine. Tous droits réservés.</p>
            <p>Auteurs: Amine El Hila & Aya Rehimi</p>
        </footer>
    </div>
</body>
<script>
const typePlatSelect = document.getElementById('plat');
const mainContent = document.getElementById('main');

    document.addEventListener("DOMContentLoaded", (event) => {
     
        

        fetch("/api/recettes")
        .then(response=>{

            return response.json();
        })
        .then( data=>{
            
            afficher_toutes_recettes(data);
        } )
        .catch(error=>{
            alert(error.message);
        } )

    });

    

    
    typePlatSelect.addEventListener('change', () => {
    const typePlatId = typePlatSelect.value;

    if (typePlatId === "all") {
        // Si "Tous" est sélectionné, on récupère toutes les recettes
        fetch('/api/recettes')
            .then(response => response.json())
            .then(tabCarte => {
                console.log(tabCarte);
                mainContent.innerHTML = '';
                afficher_toutes_recettes(tabCarte);
            })
            .catch(error => {
                alert(error.message);
            });
    } else {
        // Sinon, on récupère les recettes par type de plat
        fetch('/api/recettes/type_plat/' + typePlatId)
            .then(response => response.json())
            .then(tabCarte => {
                console.log(tabCarte);
                mainContent.innerHTML = '';
                afficher_toutes_recettes(tabCarte);
            })
            .catch(error => {
                alert(error.message);
            });
    }
});

</script>
</html>
