<?php
    session_start();
    
    $hostname = "db";
    $nom_utilisateur = "user";
    $mot_de_passe = "password";
    $database = "mydatabase";
    

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", 
          $nom_utilisateur, $mot_de_passe);
    $conn->setAttribute(PDO::ATTR_ERRMODE, 
          PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch(PDOException $e) 
  {
    echo "Connexion échouée: " . $e->getMessage();
  }



  function liste_types_plats($conn) {
    $sql = "SELECT * FROM types_plats";

    $requete = $conn->prepare($sql);
    $requete->execute();

    $resultat = $requete->fetchAll();
    
 
    return $resultat;
}


function liste_types_cuisines($conn) {
     $_sql = "SELECT * FROM types_cuisines";
     $requete = $conn->prepare($_sql);
     $requete->execute();
     $types_cuisines = $requete->fetchAll();


   return $types_cuisines;
}

?>