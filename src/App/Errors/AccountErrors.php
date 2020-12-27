<?php

namespace App\Errors;

class AccountErrors {
  public const ACCOUNT_NOT_FOUND = 'Conta não encontrada.';

  public const INCORRECT_PASSWORD = 'Sua senha está incorreta.';

  public const EMAIL_ALREADY_IN_USE = 'Este endereço de e-mail já está em uso.';
  public const EMAIL_ALREADY_VERIFIED = 'Este e-mail já foi verificado antes.';
}
