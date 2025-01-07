<?php

require_once '../../vendor/autoload.php';
use App\BddConnectlite;

header('Content-Type: application/json');

$bdd = new BddConnectlite();
$pdo = $bdd->connexion();

function getGraphiqueData($pdo, $idquestion) {
        $stmt = $pdo->query("SELECT reponse, COUNT(*) as count FROM reponses WHERE id_question = $idquestion GROUP BY reponse");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function getRegionData($pdo, $idquestion) {
    $query = "
        SELECT c.texte AS reponse, 
               COUNT(r.reponse) AS count
        FROM choix c
        LEFT JOIN reponses r 
        ON c.id = r.reponse AND r.id_question = :idquestion
        WHERE c.id_question = :idquestion
        GROUP BY c.texte
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idquestion', $idquestion, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$graphique1Data = getGraphiqueData($pdo, 1);
$graphique2Data = getGraphiqueData($pdo, 2);
$graphique3Data = getGraphiqueData($pdo, 3);
$graphique4Data = getGraphiqueData($pdo, 4);
$graphique5Data = getGraphiqueData($pdo, 5);
$graphiqueRegion = getRegionData($pdo, 4);

echo json_encode([
    'graphique1' => $graphique1Data, // age
    'graphique2' => $graphique2Data, // sexe
    'graphique3' => $graphique3Data, /// lieu de vie
    'graphique4' => $graphique4Data, // région
    'graphique5' => $graphique5Data,  // zone urbaine/rurale
    'graphiqueRegion' => $graphiqueRegion, // region

]);

?>
