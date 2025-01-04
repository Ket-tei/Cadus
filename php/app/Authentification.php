<?php

namespace App;

use App\Exceptions\AuthentificationException;

class Authentification {

  public function __construct(private IUserRepository $userRepository) { }

  /**
   * @throws AuthentificationException
   */
  public function register(string $email, string $password, string $repeat) : bool {
    $account = $this->userRepository->findUserByEmail($email);
    if ($account != null) ;

    $user = new User($email, $password);
    return $this->userRepository->saveUser($user);
  }

  /**
   * @throws AuthentificationException
   */
  public function authenticate(string $email, string $password) : string {
    $account = $this->userRepository->findUserByEmail($email);
    if ($account === null) {
        $message = "L'utilisateur n'existe pas";
        $type = "danger";
        Messages::goHome($message, $type, "../../../Cadus/html/signin.html");
    }

    if ($account->getPassword() !== $password) throw new AuthentificationException("Mot de passe incorrect");
    return "-";
  }

}