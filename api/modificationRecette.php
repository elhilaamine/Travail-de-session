<?php

require_once(__DIR__."/../config.php");

$body = json_decode(file_get_contents("php://input"));


$requete_update_recette = $conn->prepare("UPDATE `recettes` SET `titre`=:titre, `temps_de_preparation`=:temps_de_preparation, `type_de_plat`=:type_de_plat, `type_de_cuisine`=:type_de_cuisine, `desc_courte`=:desc_courte, `image_url`=:image_url  WHERE `id`=:id");
$requete_update_recette->bindParam(":titre", $body->titre);
$requete_update_recette->bindParam(":temps_de_preparation", $body->temps_de_preparation);
$requete_update_recette->bindParam(":type_de_plat", $body->type_de_plat);
$requete_update_recette->bindParam(":type_de_cuisine", $body->type_de_cuisine);
$requete_update_recette->bindParam(":desc_courte", $body->desc_courte);
$requete_update_recette->bindParam(":image_url", $body->image_url);
$requete_update_recette->bindParam(":id", $id);
$requete_update_recette->execute();

$requete_delete_etapes = $conn->prepare("DELETE FROM `etapes_de_preparation` WHERE `recette_id`=:id");
$requete_delete_etapes->bindParam(":id", $id);
$requete_delete_etapes->execute();


foreach ($body->etapes_de_preparation as $etape) {
    $requete_insert_etape = $conn->prepare("INSERT INTO `etapes_de_preparation` (`recette_id`, `etape`) VALUES (:id, :etape_texte)");
    $requete_insert_etape->bindParam(":id", $id);
    $requete_insert_etape->bindParam(":etape_texte", $etape);
    $requete_insert_etape->execute();
}



$requete_delete_ingredients = $conn->prepare("DELETE FROM `ingredients` WHERE `recette_id`=:id");
$requete_delete_ingredients->bindParam(":id", $id);
$requete_delete_ingredients->execute();



foreach ($body->ingredients as $ingredient) {
    $requete_insert_ingredient = $conn->prepare("INSERT INTO `ingredients` (`nom`, `quantite`, `quantite_equivalente`, `recette_id`) VALUES (:nom, :quantite, :quantite_equivalente, :id)");
    $requete_insert_ingredient->bindParam(":nom", $ingredient->nom);
    $requete_insert_ingredient->bindParam(":quantite", $ingredient->quantite);
    $requete_insert_ingredient->bindParam(":quantite_equivalente", $ingredient->quantite_equivalente);
    $requete_insert_ingredient->bindParam(":id", $id);
    $requete_insert_ingredient->execute();
}


$requete_select_recette = $conn->prepare("SELECT * FROM `recettes` WHERE `id`=:id");
$requete_select_recette->bindParam(":id", $id);
$requete_select_recette->execute();
$recette = $requete_select_recette->fetch(PDO::FETCH_ASSOC);

echo json_encode($recette);

?>