<?php
require_once(__DIR__."/../config.php");

// Récupérer l'ID du type de plat depuis les paramètres GET
#$typeId = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($id == 0) {
        // Si $id vaut 0, retourner 7 plats aléatoires
        $requete = $conn->query("SELECT * FROM recettes ORDER BY RAND() LIMIT 7");
        $recettes = $requete->fetchAll(PDO::FETCH_ASSOC);
 } else {
        // Sinon, retourner les plats correspondant au type de plat
        $requete = $conn->prepare("SELECT * FROM recettes WHERE type_de_plat = :type_plat_id");
        $requete ->bindParam(":type_plat_id", $id);
        $requete->execute();
        $recettes = $requete->fetchAll(PDO::FETCH_ASSOC);
        
 }
    echo json_encode($recettes);

?>