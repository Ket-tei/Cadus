<?php
if(!session_id())
    session_start();

use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\AuthentificationException;
use App\Exceptions\BddConnectException;
use App\MariaDBUserRepository;
use App\Messages;

require_once '../../vendor/autoload.php';

$bdd = new BddConnectlite();

try {
    $pdo = $bdd->connexion();
} catch(BddConnectException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if(!isset($_SESSION['auth'])) {

    header('Location: ../../html/signin.html', true, 301);
    exit();

}

$email = $_SESSION['auth'];
$stmt = $pdo->prepare("SELECT sondage_effectue FROM utilisateurs WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['sondage_effectue']) {
    echo "<div class='dejaRepondu'>Vous avez déjà répondu au sondage. Merci pour votre participation.</div>";
    exit;
}

$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($questions as $question) {
    echo "<div class='form-group'>";
    echo "<label for='question-{$question['id']}'>" . htmlspecialchars($question['texte']) . "</label>";

    if ($question['type_de_reponse'] === 'choix') {
        $choicesStmt = $pdo->prepare("SELECT * FROM choix WHERE id_question = :id_question");
        $choicesStmt->bindParam(':id_question', $question['id']);
        $choicesStmt->execute();
        $choix = $choicesStmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<select class='form-control' name='reponses[{$question['id']}]' id='question-{$question['id']}' required>";
        echo "<option value=''>Sélectionnez une réponse</option>";
        foreach ($choix as $choice) {
            echo "<option value='" . htmlspecialchars($choice['texte']) . "'>" . htmlspecialchars($choice['texte']) . "</option>";
        }
        echo "</select>";
    } elseif ($question['type_de_reponse'] === 'numerique') {
        echo "<input type='number' class='form-control' name='reponses[{$question['id']}]' id='question-{$question['id']}' required>";
    } else {
        echo "<input type='text' class='form-control' name='reponses[{$question['id']}]' id='question-{$question['id']}' required>";
    }

    echo "</div>";
}
?>
