<?php


if(!session_id())
  session_start();

use App\Authentification;
use App\BddConnectlite;
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
  Messages::goHome($e->getMessage(), $e->getType(), "../../html/signin.html");
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $hashpassword = md5($_POST['password']);
    $auth->authenticate($_POST['email'], $hashpassword);
    $_SESSION['auth'] = $_POST['email'];
    if($trousseau->findRoleByEmail($_POST['email']) == 'admin') {
        header('Location: ../../html/adminPage.html');
    }
    else {
        header('Location: ../../html/userPage.html');
    }
  }
  catch(BddConnectException $e) {
    Messages::goHome($e->getMessage(), $e->getType(),'../../html/signin.html');
  }


}

require_once 'footer.php';