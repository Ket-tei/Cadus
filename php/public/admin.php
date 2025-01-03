<?php

use App\Messages;

if(!session_id())
  session_start();

$title = "Page Administateur";
require_once './header.php';


if(isset($_SESSION['auth'])) {
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
  Messages::goHome("Accès interdit", "danger", "public/index.php");
}

echo "</div></div>";
require_once './footer.php';
?>
