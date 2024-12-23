<?php

namespace App;

class MariaDBUserRepository implements IUserRepository {

  public function __construct(private \PDO $dbConnexion) { }

  /**
   * Effectue l'enregistrement d'un utilisateur (email/password) dans la base MariaDB
   * retourne true en cas de succès et false en cas d'erreur
   * @param User $user
   * @return bool
   */
  public function saveUser(User $user) : bool {
    try {
      $hashpassword = md5($user->getPassword());
      $sql ="INSERT INTO utilisateur (login, password, role) VALUES ('".$user->getEmail()."','".$hashpassword."', 'user')";
      $affectedRows = $this->dbConnexion->exec($sql);
      if ($affectedRows > 0) return true;
      return false;
    } catch (\PDOException $e) {
      return false;
    }
  }
  


  /**
   * Recherche un utilisateur à partir de son email dans la base MariaDB.
   * Retourne l'utilisateur si l'utilisateur est enregistré. Sinon null
   * @param string $email
   * @return User|null
   */
  public function findUserByEmail(string $email) : ?User {
    $sql = "SELECT * FROM utilisateur WHERE login = :email";
    $stmt = $this->dbConnexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($result === false) return null;
    return new User($result['login'], $result['password']);
  }
}