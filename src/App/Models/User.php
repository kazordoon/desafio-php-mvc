<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
  protected static $tableName = 'users';

  public static function findByEmail(string $email) {
    $data = static::getTable()->where('email', '=', $email)->first();
    return $data;
  }
}
