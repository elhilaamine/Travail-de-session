<?php


require_once(__DIR__."/../config.php");

$requete = $conn->query("SELECT * FROM recettes ORDER BY RAND() LIMIT 7");
$recettes = $requete->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($recettes);

?>