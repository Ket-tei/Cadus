<?php

use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\AuthentificationException;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;

if(!session_id())
  session_start();

$title = "Page Administateur";
require_once '../../vendor/autoload.php';

require_once './header.php';
$bdd = new BddConnectlite();

try {
  $pdo = $bdd->connexion();
}
catch(BddConnectException $e) {
  Messages::goHome(
      $e->getMessage(),
      $e->getType(),
      "./signup.php");
  die();
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if(isset($_SESSION['auth']) && $trousseau->findRoleByEmail($_SESSION['auth']) == 'admin') {
echo "<div class='container mt-5'>
  <h2>Panel d'administration<h2>
  <div class='container'>";

  echo "<a href='index.php'>
  <img src='assets/img/imgsql.jpg' width='331' height='500' class='img-fluid img-thumbnail' alt=''>
</a>";
  $_SESSION['flash']['success'] = "Déconnexion réussie";
  unset($_SESSION['auth']);
}
else {
  Messages::goHome("Accès interdit", "danger", "../../../Cadus/html/signin.html");
}

echo "</div></div>";
require_once './footer.php';
?>
