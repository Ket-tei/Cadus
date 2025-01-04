<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../../Cadus/css/navbar.css" />
    <link rel="stylesheet" href="../../../Cadus/css/login.css" />
    <script src="https://kit.fontawesome.com/44edc4c182.js" crossorigin="anonymous"></script>
    <title>Sondage</title>
</head>
<body>
<script src="../../js/navbar.js"></script>

<div class="container">
    <h1>Sondage</h1>
    <form id="survey-form" method="POST" action="../app/envoiFormulaire.php">
        <!-- Les questions seront chargées ici dynamiquement -->
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("../php/app/recupQuestions.php")
            .then(response => response.text())
            .then(html => {
                document.getElementById("survey-form").innerHTML = html;
            })
            .catch(error => console.error("Erreur lors du chargement des questions :", error));
    });
</script>

</body>
</html>
