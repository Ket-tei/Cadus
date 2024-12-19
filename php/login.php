<?php
        $server = "82.66.207.188";
        $user = "nicolas";
        $password = "NN8yM8NXSQyaYvd";
        $dbname = "SAE";

        $connexionBD = new PDO("pgsql:host=$server;dbname=$dbname", $user, $password);

        if ($connexionBD->errorCode()) {
            throw new Exception("Impossible de se connecter à la base de données : " . $connexionBD->errorInfo()[2]);
        }
        echo "test";

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = pg_escape_string($connexionBD, $_POST['login']);
            $password = pg_escape_string($connexionBD, $_POST['password']);

            $sql = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
            $EtatConnexion = $connexionBD->query($sql);
            
            if ($EtatConnexion->rowCount() === 1) {
                echo "Connexion réussie";
            } else {
                echo "Connexion échouée";
            }
        }
        ?>