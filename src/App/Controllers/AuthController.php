<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\AccountErrors;
use App\Errors\ValidationErrors;
use App\Models\User;

class AuthController extends Controller {
  public function redirectIfLoggedIn() {
    $isTheUserLoggedIn = isset($_SESSION['user_id']);
    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL . 'account');
    }
  }

  public function index() {
    $this->redirectIfLoggedIn();

    $successMessage = $_SESSION['success_message'] ?? null;
    $errorMessage = $_SESSION['error_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'success_message' => $successMessage,
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('login', $data);
  }

  public function auth() {
    $this->redirectIfLoggedIn();

    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $password = filter_input(INPUT_POST, 'password');

      $areTheFieldsEmpty = empty($email) || empty($password);
      if ($areTheFieldsEmpty) {
        $_SESSION['error_message'] = ValidationErrors::EMPTY_FIELDS;
        redirectTo(BASE_URL . 'login');
      }

      $user = User::findByEmail($email);

      $userNotFound = empty($user);
      if ($userNotFound) {
        $_SESSION['error_message'] = AccountErrors::ACCOUNT_NOT_FOUND;
        redirectTo(BASE_URL . 'login');
      }

      $isThePasswordIncorrect = !password_verify($password, $user->password);
      if ($isThePasswordIncorrect) {
        $_SESSION['error_message'] = AccountErrors::INCORRECT_PASSWORD;
        redirectTo(BASE_URL . 'login');
      }

      $emailHasNotBeenVerified = !$user->verified;
      if ($emailHasNotBeenVerified) {
        $emailVerificationPage = BASE_URL . "send_verification_email?email={$email}";
        redirectTo($emailVerificationPage);
      }

      $_SESSION['user_id'] = $user->id;

      redirectTo(BASE_URL . 'account');
    }
  }
}
