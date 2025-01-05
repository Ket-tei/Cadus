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



if (!isset($_SESSION['auth'])) {
    echo json_encode(['status' => 'erreur', 'message' => 'Non connecté']);
}
echo json_encode(['status' => 'success']);
