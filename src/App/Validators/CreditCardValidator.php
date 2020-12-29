<?php

namespace App\Validators;

class CreditCardValidator {
  static function validateCreditCardNumber(string $creditCardNumber) {
    $numberRegex = '/^\d+$/';
    return preg_match($numberRegex, $creditCardNumber);
  }

  static function validateCreditCardExpirationDate(string $creditCardExpirationDate) {
    $expirationDateRegex = '/^\d{2}\/\d{2}$/';
    return preg_match($expirationDateRegex, $creditCardExpirationDate);
  }

  static function validateCreditCardCode(string $creditCardCode) {
    $codeRegex = '/^\d{3}$/';
    return preg_match($codeRegex, $creditCardCode);
  }
}
