<?php

namespace App;

interface IUserRepository {
  public function saveUser(User $user): bool;
  public function findUserByEmail(string $email): ?User;
}