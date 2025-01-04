<?php
if(!session_id())
  session_start();

use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\AuthentificationException;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;


require_once 'header.php';
require_once '../../vendor/autoload.php';

$bdd = new BddConnectlite();

try {
  $pdo = $bdd->connexion();
}
catch(BddConnectException $e) {
  echo "hello";
  Messages::goHome(
    $e->getMessage(),
    $e->getType(),
    "./signup.php");
  die();
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repassword'])) {
      throw new AuthentificationException("Accès interdit");
    }
    $retour = $auth->register($_POST['email'], $_POST['password'], $_POST['repassword']);
    $message = "Vous êtes enregistré. Vous pouvez vous authentifier";
    $type = "success";
  }
  catch(AuthentificationException $e) {
    $message = $e->getMessage();
    $type = $e->getType();
  }
}
else {
  $message = "Accès interdit";
  $type = "danger";
}

Messages::goHome($message, $type, "../../../Cadus/html/signin.html");

require_once 'footer.php';