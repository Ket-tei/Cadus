<?php
use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\AuthentificationException;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;

if(!session_id())
    session_start();

require_once '../../vendor/autoload.php';

require_once '../public/header.php';
$bdd = new BddConnectlite();

try {
    $pdo = $bdd->connexion();
}
catch(BddConnectException $e) {
    Messages::goHome(
        $e->getMessage(),
        $e->getType(),
        "../../html/signin.html");
    die();
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if(!isset($_SESSION['auth']) || $trousseau->findRoleByEmail($_SESSION['auth']) !== 'admin') {
    header("Location: ../../html/signin.html");
    exit;
}

