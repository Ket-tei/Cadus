<?php

require_once '../../vendor/autoload.php';
use App\BddConnectlite;

header('Content-Type: application/json');

$bdd = new BddConnectlite();
$pdo = $bdd->connexion();

function getSoutienPsychologiqueData($pdo, $idLieuDeVie, $idSoutienPsychologique) {
    // Requête pour récupérer le taux de personnes ayant besoin de soutien psychologique par lieu de vie
    $query = "
        SELECT c.texte AS lieu_de_vie, 
               SUM(CASE WHEN r.reponse = 'Oui' THEN 1 ELSE 0 END) AS besoin_soutien,
               COUNT(r.reponse) AS total
        FROM choix c
        LEFT JOIN reponses r ON c.id = r.reponse AND r.id_question = :idLieuDeVie
        LEFT JOIN reponses s ON s.id_sessions = r.id_sessions AND s.id_question = :idSoutienPsychologique
        WHERE c.id_question = :idLieuDeVie
        GROUP BY c.texte
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idLieuDeVie', $idLieuDeVie, PDO::PARAM_INT);
    $stmt->bindParam(':idSoutienPsychologique', $idSoutienPsychologique, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des données (ici, j'assume que la question du lieu de vie est l'id 4 et que celle du soutien psychologique est l'id 6)
$graphiqueLieuSoutien = getSoutienPsychologiqueData($pdo, 3, 10);
echo json_encode([
    'graphiqueLieuSoutien' => $graphiqueLieuSoutien,
]);

?>
