<?php

require_once(__DIR__."/../config.php");


$body = json_decode(file_get_contents("php://input"));




$requete = $conn->prepare("INSERT INTO `recettes` (`titre`, `temps_de_preparation`, `type_de_plat`, `type_de_cuisine`, `desc_courte`, `image_url`) VALUES (:titre, :temps_de_preparation, :type_de_plat, :type_de_cuisine, :desc_courte, :image_url)");
$requete->bindParam(":titre", $body->titre);
$requete->bindParam(":temps_de_preparation", $body->temps_de_preparation); 
$requete->bindParam(":type_de_plat", $body->type_de_plat);
$requete->bindParam(":type_de_cuisine", $body->type_de_cuisine);
$requete->bindParam(":desc_courte", $body->desc_courte);
$requete->bindParam(":image_url", $body->image_url);
$requete->execute();


$id = $conn->lastInsertId();




$etape_numero = 1;
foreach ($body->etapes_de_preparation as $etape) {
    $requete_etapes = $conn->prepare("INSERT INTO etapes_de_preparation (recette_id, etape_numero, etape) VALUES (:recette_id, :etape_numero, :etape_texte)");
    $requete_etapes->bindParam(":recette_id", $id);
    $requete_etapes->bindParam(":etape_numero", $etape_numero);  
    $requete_etapes->bindParam(":etape_texte", $etape);
    $requete_etapes->execute();
    $etape_numero++;
}




foreach ($body->ingredients as $ingredient) {
    $requete_ingredients = $conn->prepare("INSERT INTO ingredients (nom, quantite, quantite_equivalente, recette_id) VALUES (:nom, :quantite, :quantite_equivalente, :recette_id)");
    $requete_ingredients->bindParam(":nom", $ingredient->nom);
    $requete_ingredients->bindParam(":quantite", $ingredient->quantite);
    $requete_ingredients->bindParam(":quantite_equivalente", $ingredient->quantite_equivalente);
    $requete_ingredients->bindParam(":recette_id", $id);
    $requete_ingredients->execute();
}





$requete = $conn->prepare("SELECT * FROM `recettes` WHERE `id`=:id");
$requete->bindParam(":id", $id);
$requete->execute();

$recette = $requete->fetch(PDO::FETCH_ASSOC);

echo json_encode($recette);

?>