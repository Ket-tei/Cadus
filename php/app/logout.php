<?php
session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);

    $_SESSION['flash']['success'] = "Déconnexion réussie";
}

session_destroy();
header("Location: ../../index.html");
exit;
?>
