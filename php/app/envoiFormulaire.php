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
        "../../html/signin.html"
    );
    die();
}

if (!isset($_SESSION['auth'])) {
    Messages::goHome("Accès interdit", "danger", "../../html/signin.html");
    die();
}

$email = $_SESSION['auth'];
$stmt = $pdo->prepare("SELECT id, sondage_effectue FROM utilisateurs WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user['sondage_effectue']) {
    Messages::goHome("Vous avez déjà répondu au sondage.", "info", "../../html/userPage.html");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponses'])) {
    $responses = $_POST['reponses'];
    $userId = $user['id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO reponses (id_question, id_utilisateur, reponse) VALUES (:id_question, :id_utilisateur, :reponse)");

        foreach ($responses as $questionId => $response) {
            $stmt->bindParam(':id_question', $questionId);
            $stmt->bindParam(':id_utilisateur', $userId);
            $stmt->bindParam(':reponse', $response);
            $stmt->execute();
        }

        $updateStmt = $pdo->prepare("UPDATE utilisateurs SET sondage_effectue = TRUE WHERE id = :id");
        $updateStmt->bindParam(':id', $userId);
        $updateStmt->execute();

        $pdo->commit();

        $_SESSION['flash']['success'] = "Merci d'avoir répondu au sondage.";
        header('Location: ../../html/userPage.html');
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['flash']['danger'] = "Une erreur est survenue lors de la soumission du sondage. Veuillez réessayer.";
        header('Location: ../../html/userPage.html');
    }
} else {
    $_SESSION['flash']['danger'] = "Aucune réponse n'a été soumise.";
    header('Location: ../../html/userPage.html');
}

exit();
?>
