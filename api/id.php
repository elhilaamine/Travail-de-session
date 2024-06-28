<?php




require_once(__DIR__."/../config.php");

$requete = $conn->prepare("SELECT * FROM recettes WHERE `id`=:id");
$requete->bindParam(":id", $id);
$requete->execute();

$recette = $requete->fetch();




// Fetch ingredients associated with the recipe
$ingredientsQuery = $conn->prepare("SELECT * FROM ingredients WHERE recette_id = :id");
$ingredientsQuery->bindParam(":id", $id);
$ingredientsQuery->execute();
$ingredients = $ingredientsQuery->fetchAll();

// Fetch preparation steps associated with the recipe
$etapesQuery = $conn->prepare("SELECT * FROM etapes_de_preparation WHERE recette_id = :id");
$etapesQuery->bindParam(":id", $id);
$etapesQuery->execute();
$etapes = $etapesQuery->fetchAll();

$recette['ingredients'] = $ingredients;
$recette['etapes_de_preparation'] = $etapes;




echo json_encode($recette);












?>