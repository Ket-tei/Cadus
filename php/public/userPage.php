<?php
if(!session_id())
    session_start();

use App\Authentification;
use App\BddConnectlite;
use App\Exceptions\AuthentificationException;
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
    Messages::goHome(
        $e->getMessage(),
        $e->getType(),
        "./signup.php");
    die();
}

$trousseau = new MariaDBUserRepository($pdo);
$auth = new Authentification($trousseau);

if(!isset($_SESSION['auth'])) {
    Messages::goHome("Accès interdit", "danger", "../../../Cadus/html/signin.html");
    die();
}
$email = $_SESSION['auth'];
$stmt = $pdo->prepare("SELECT sondage_effectue FROM utilisateurs WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../../Cadus/css/navbar.css" />
    <link rel="stylesheet" href="../../../Cadus/css/login.css" />
    <script src="https://kit.fontawesome.com/44edc4c182.js" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>
<body>
<script src="../../js/navbar.js"></script>
</body>
</html>


<?php
if ($user['sondage_effectue']) {
    echo "<div class='dejaRepondu'>Vous avez déjà répondu au sondage. Merci pour votre participation.</div>";
    require_once './footer.php';
    die();
}
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Sondage</h1>
    <form method="POST" action="../app/envoiFormulaire.php">
        <?php foreach ($questions as $question): ?>
            <div class="form-group">
                <label for="question-<?= $question['id'] ?>"><?= htmlspecialchars($question['texte']) ?></label>
                <?php if ($question['type_de_reponse'] === 'choix'): ?>
                    <?php
                    $choicesStmt = $pdo->prepare("SELECT * FROM choix WHERE id_question = :id_question");
                    $choicesStmt->bindParam(':id_question', $question['id']);
                    $choicesStmt->execute();
                    $choices = $choicesStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <select class="form-control" name="reponses[<?= $question['id'] ?>]" id="question-<?= $question['id'] ?>" required>
                        <option value="">Sélectionnez une réponse</option>
                        <?php foreach ($choices as $choice): ?>
                            <option value="<?= htmlspecialchars($choice['texte']) ?>"><?= htmlspecialchars($choice['texte']) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif ($question['type_de_reponse'] === 'numerique'): ?>
                    <input type="number" class="form-control" name="reponses[<?= $question['id'] ?>]" id="question-<?= $question['id'] ?>" required>
                <?php else: ?>
                    <input type="text" class="form-control" name="reponses[<?= $question['id'] ?>]" id="question-<?= $question['id'] ?>" required>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>



require_once './footer.php';
?>