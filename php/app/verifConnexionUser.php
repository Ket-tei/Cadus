<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['auth'])) {
    // Rediriger vers la page de connexion
    header("Location: ../../html/signin.html");
    exit;
}

