<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Validators\UserValidator;

class EmailVerificationController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $emailVerificationToken = filter_input(INPUT_GET, 'token');

    $isTheEmailFieldEmpty = empty($email);
    if ($isTheEmailFieldEmpty) {
      $_SESSION['error_message'] = 'Preencha o campo de e-mail.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
    if ($isAnInvalidEmail) {
      $_SESSION['error_message'] = 'O e-mail fornecido tem um formato inválido.';
      redirectTo(BASE_URL . 'register');
    }

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error_message'] = 'Não há nenhuma conta associada ao e-mail fornecido.';
      redirectTo(BASE_URL . 'login');
    }

    $emailAlreadyVerified = $user->verified;
    if ($emailAlreadyVerified) {
      $_SESSION['error_message'] = 'Este e-mail já foi verificado antes.';
      redirectTo(BASE_URL . 'login');
    }

    $isAnInvalidEmailVerificationToken = $user->email_verification_token !== $emailVerificationToken;
    if ($isAnInvalidEmailVerificationToken) {
      $_SESSION['error_message'] = 'Código inválido.';
      redirectTo(BASE_URL . 'login');
    }

    User::findByIdAndUpdate($user->id, [
      'verified' => true,
      'email_verification_token' => null
    ]);

    $_SESSION['success_message'] = 'Seu e-mail foi verificado com sucesso.';
    redirectTo(BASE_URL . '/login');
  }
}
