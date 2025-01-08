<?php

use App\BddConnectlite;
use App\Exceptions\BddConnectException;
use App\Messages;

require_once '../public/header.php';
require_once '../../vendor/autoload.php';

$bdd = new BddConnectlite();

try {
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome(
        $e->getMessage(),
        $e->getType(),
        "../../html/contact.html"
    );
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
        Messages::goHome(
            "Tous les champs sont obligatoires.",
            "danger",
            "../../html/contact.html"
        );
        die();
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (nom, prenom, email, message)
            VALUES (:nom, :prenom, :email, :message)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':message' => $message
        ]);

        Messages::goHome(
            "Votre message a bien été envoyé.",
            "success",
            "../../html/contact.html"
        );
    } catch (Exception $e) {
        Messages::goHome(
            "Erreur lors de l'enregistrement : " . $e->getMessage(),
            "danger",
            "../../html/contact.html"
        );
        die();
    }
} else {
    Messages::goHome(
        "Accès interdit.",
        "danger",
        "../../html/contact.html"
    );
}

require_once '../public/footer.php';
