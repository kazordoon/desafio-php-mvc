<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\AccountErrors;
use App\Errors\TokenErrors;
use App\Errors\ValidationErrors;
use App\Models\User;
use App\Validators\UserValidator;

class EmailVerificationController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $emailVerificationToken = filter_input(INPUT_GET, 'token');

    $isTheEmailFieldEmpty = empty($email);
    if ($isTheEmailFieldEmpty) {
      $_SESSION['error_message'] = ValidationErrors::EMPTY_EMAIL_FIELD;
      redirectTo(BASE_URL . 'recover_password');
    }

    $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
    if ($isAnInvalidEmail) {
      $_SESSION['error_message'] = ValidationErrors::INVALID_EMAIL_FORMAT;
      redirectTo(BASE_URL . 'register');
    }

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error_message'] = AccountErrors::ACCOUNT_NOT_FOUND;
      redirectTo(BASE_URL . 'login');
    }

    $emailAlreadyVerified = $user->verified;
    if ($emailAlreadyVerified) {
      $_SESSION['error_message'] = AccountErrors::EMAIL_ALREADY_VERIFIED;
      redirectTo(BASE_URL . 'login');
    }

    $isAnInvalidEmailVerificationToken = $user->email_verification_token !== $emailVerificationToken;
    if ($isAnInvalidEmailVerificationToken) {
      $_SESSION['error_message'] = TokenErrors::INVALID_TOKEN;
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
