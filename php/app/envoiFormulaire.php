<?php
if (!session_id()) {
    session_start();
}

use App\BddConnectlite;
use App\Exceptions\BddConnectException;
use App\Messages;

require_once '../../vendor/autoload.php';

$bdd = new BddConnectlite();

try {
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome(
        $e->getMessage(),
        $e->getType(),
        "../../../Cadus/html/signin.html"
    );
    die();
}

// Vérification de l'utilisateur connecté
if (!isset($_SESSION['auth'])) {
    Messages::goHome("Accès interdit", "danger", "../../../Cadus/html/signin.html");
    die();
}

$email = $_SESSION['auth'];
$stmt = $pdo->prepare("SELECT id, sondage_effectue FROM utilisateurs WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// on revérifie à nouveau à l'envoi pour être sur qu'il n'a pas été répondu dans un autre onglet en même temps
if ($user['sondage_effectue']) {
    Messages::goHome("Vous avez déjà répondu au sondage.", "info", "userPage.php");
    die();
}

// Traitement des réponses
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponses'])) {
    $responses = $_POST['reponses'];
    $userId = $user['id'];

    try {
        // Démarrer une transaction pour garantir la cohérence des données
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO reponses (id_question, id_utilisateur, reponse) VALUES (:id_question, :id_utilisateur, :reponse)");

        foreach ($responses as $questionId => $response) {
            $stmt->bindParam(':id_question', $questionId);
            $stmt->bindParam(':id_utilisateur', $userId);
            $stmt->bindParam(':reponse', $response);
            $stmt->execute();
        }

        // Marquer le sondage comme effectué
        $updateStmt = $pdo->prepare("UPDATE utilisateurs SET sondage_effectue = TRUE WHERE id = :id");
        $updateStmt->bindParam(':id', $userId);
        $updateStmt->execute();

        // Valider la transaction
        $pdo->commit();

        $_SESSION['flash']['success'] = "Merci d'avoir répondu au sondage.";
        header('Location: userPage.php');
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        $_SESSION['flash']['danger'] = "Une erreur est survenue lors de la soumission du sondage. Veuillez réessayer.";
        header('Location: userPage.php');
    }
} else {
    $_SESSION['flash']['danger'] = "Aucune réponse n'a été soumise.";
    header('Location: userPage.php');
}

exit();
?>
