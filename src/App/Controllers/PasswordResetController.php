<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Validators\UserValidator;

class PasswordResetController extends Controller {
  public function index() {
    $errorMessage = $_SESSION['error_message'] ?? null;

    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $passwordRecoveryToken = filter_input(INPUT_GET, 'token');

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error_message'] = 'Não há nenhuma conta associada ao email fornecido..';
      redirectTo(BASE_URL . 'recover_password');
    }

    $hasAnInvalidPasswordRecoveryToken = $user->password_recovery_token !== $passwordRecoveryToken;
    if ($hasAnInvalidPasswordRecoveryToken) {
      $_SESSION['error_message'] = 'Código inválido.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $now = date('Y-m-d H:i:s', time());
    $passwordRecoveryTokenHasExpired = $user->password_token_expiration_time < $now;
    if ($passwordRecoveryTokenHasExpired) {
      $_SESSION['error_message'] = 'O código para a recuperação de senha expirou.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $_SESSION['user_id_to_reset_pass'] = $user->id;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    $this->render('reset_password', $data);
  }

  public function reset() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $userId = $_SESSION['user_id_to_reset_pass'] ?? null;

      $password = filter_input(INPUT_POST, 'password');
      $repeatedPassword = filter_input(INPUT_POST, 'repeatedPassword');

      $hasAnInvalidPasswordLength = !UserValidator::hasAValidPasswordLength($password);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error_message'] = 'A senha deve ter entre 8 e 50 carácteres.';
        redirectTo(BASE_URL . $_SERVER['REQUEST_URI']);
      }

      $passwordsAreDifferent = !UserValidator::areThePasswordsTheSame(
        $password,
        $repeatedPassword
      );
      if ($passwordsAreDifferent) {
        $_SESSION['error_message'] = 'As senhas não coincidem.';
        redirectTo(BASE_URL . $_SERVER['REQUEST_URI']);
      }

      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
      User::findByIdAndUpdate($userId, [
        'password' => $hashedPassword
      ]);

      User::findByIdAndUpdate($userId, [
        'password_recovery_token' => null,
        'password_token_expiration_time' => null
      ]);

      unset($_SESSION['user_id']);

      $_SESSION['success_message'] = 'Sua senha foi atualizada com sucesso.';
      redirectTo(BASE_URL);
    }
  }
}
