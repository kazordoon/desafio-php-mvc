<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Providers\Mail;
use App\Validators\UserValidator;
use PHPMailer\PHPMailer\Exception;

class PasswordRecoveryController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['userId']);

    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL);
    }

    $errorMessage = $_SESSION['error_message'] ?? null;
    $successMessage = $_SESSION['success_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'error_message' => $errorMessage,
      'success_message' => $successMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('recover_password', $data);
  }

  public function sendRecoveryToken() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

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
        $_SESSION['error_message'] = 'Não há nenhuma conta associada ao email fornecido.';
        redirectTo(BASE_URL . 'recover_password');
      }

      $passwordRecoveryToken = generateToken();
      $oneHour = time() + 3600;
      $passwordTokenExpirationTime = date('Y-m-d H:i:s', $oneHour);

      User::findByIdAndUpdate($user->id, [
        'password_recovery_token' => $passwordRecoveryToken,
        'password_token_expiration_time' => $passwordTokenExpirationTime
      ]);

      $passwordRecoveryLink = BASE_URL . "reset_password?email={$email}&token={$passwordRecoveryToken}";
      $mailMessageContent = "Esqueceu sua senha ? Use este link para recuperá-la: {$passwordRecoveryLink}";
      $mail = new Mail;
      $mail->setRecipient($email, $user->name);
      $mail->writeContent('Recover password', $mailMessageContent);

      try {
        $mail->send();
        $_SESSION['success_message'] = 'Uma mensagem de e-mail com o link de recuperação de senha foi enviada para sua caixa de entrada.';
      } catch (Exception $e) {
        $_SESSION['error_message'] = 'Não foi possível enviar uma mensagem de e-mail para seu e-mail, tente novamente.';
      }

      redirectTo(BASE_URL . 'recover_password');
    }
  }
}
