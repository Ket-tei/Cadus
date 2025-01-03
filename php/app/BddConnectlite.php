<?php

namespace App;

use App\Exceptions\BddConnectException;

class BddConnectlite {
    public \PDO $pdo;
    protected ?string $cheminFichier = null;

    public function __construct() {
        $this->cheminFichier = '../../identifier.sqlite';
    }

    /**
     * @throws BddConnectException
     */
    public function connexion() : \PDO {
        try {
            $dsn = "sqlite:" . $this->cheminFichier;
            $this->pdo = new \PDO($dsn);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new BddConnectException($e->getMessage() . " - Erreur de connexion BDD : vérifier le chemin du fichier sqlite.");
        }

        return $this->pdo;
    }
}
