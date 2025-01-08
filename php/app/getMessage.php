<?php


use App\BddConnectlite;
use App\Exceptions\BddConnectException;

require_once '../../vendor/autoload.php';

$bdd = new BddConnectlite();

try {
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    die();
}

try {
    $stmt = $pdo->query("SELECT nom, prenom, message, date_submission FROM contacts ORDER BY date_submission DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
} catch (Exception $e) {
    echo json_encode(["error" => "Erreur lors de la récupération des messages : " . $e->getMessage()]);
    die();
}
