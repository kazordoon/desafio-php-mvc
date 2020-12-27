<?php

namespace App\Validators;

class UserValidator {
  public static function hasAValidNameLength(string $name) {
    $maxLength = 255;
    return strlen($name) <= $maxLength;
  }

  public static function isAValidEmail(string $email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public static function hasAValidPasswordLength(string $password) {
    $minLength = 8;
    $maxLength = 50;
    return strlen($password) >= $minLength && strlen($password) <= $maxLength;
  }
}
