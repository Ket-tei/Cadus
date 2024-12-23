<?php


if(!session_id())
  session_start();

use App\Authentification;
use App\BddConnect;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;

require_once 'header.php';
require_once '../../vendor/autoload.php';

$bdd = new BddConnect();

try {
  $pdo = $bdd->connexion();
}
catch(BddConnectException $e) {
  Messages::goHome($e->getMessage(), $e->getType(), "public/index.php");
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $hashpassword = md5($_POST['password']);
    $auth->authenticate($_POST['email'], $hashpassword);

    $_SESSION['auth'] = $_POST['email'];
    header('Location: secure.php');
  }
  catch(BddConnectException $e) {
    Messages::goHome($e->getMessage(), $e->getType(),'public/index.php');
  }


}

require_once 'footer.php';