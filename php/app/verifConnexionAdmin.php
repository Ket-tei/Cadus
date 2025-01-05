<?php
// Assurez-vous que les en-têtes sont envoyés avant tout contenu HTML
header('Content-Type: application/json');

use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;

if (!session_id()) {
    session_start();
}

require_once '../../vendor/autoload.php';

try {
    $bdd = new BddConnectlite();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    echo json_encode(['status' => 'erreur', 'message' => $e->getMessage()]);
    die();
}

if (!isset($_SESSION['auth'])) {
    echo json_encode(['status' => 'erreur', 'message' => 'Non connecté']);
    exit;
}

$trousseau = new MariaDBUserRepository($pdo);

if ($trousseau->findRoleByEmail($_SESSION['auth']) !== 'admin') {
    echo json_encode(['status' => 'erreur', 'message' => 'Non connecté']);
    exit;
}

// Si c'est un administrateur, continuez à afficher la page admin
echo json_encode(['status' => 'success']);
