<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
  protected static $tableName = 'users';

  public string $id;
  public string $name;
  public string $email;
  public string $password;
  public int $passwordTokenExpirationTime;
  public string $passwordRecoveryToken;
  public bool $verified;
  public string $emailVerificationToken;

  public static function findByEmail(string $email) {
    $data = static::getTable()->where('email', '=', $email)->first();
    return $data;
  }
}
