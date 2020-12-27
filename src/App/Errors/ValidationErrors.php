<?php

namespace App\Errors;

class ValidationErrors {
  public const INVALID_NAME_LENGTH = 'Nome muito comprido, utilize apenas nome e sobrenome.';

  public const INVALID_EMAIL_FORMAT = 'O e-mail fornecido possui um formato inválido.';

  public const DIFFERENT_PASSWORDS = 'As senhas não coincidem.';
  public const INVALID_PASSWORD_LENGTH = 'A senha deve ter entre 8 e 50 carácteres.';

  public const EMPTY_FIELDS = 'Preencha todos os campos.';
  public const EMPTY_EMAIL_FIELD = 'Preencha o campo de e-mail.';
  public const EMPTY_NAME_FIELD = 'Preencha o campo do nome.';
}
