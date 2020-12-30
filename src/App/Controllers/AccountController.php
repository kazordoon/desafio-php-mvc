<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\AccountErrors;
use App\Errors\ValidationErrors;
use App\Models\User;
use App\Validators\UserValidator;

class AccountController extends Controller {
  public function index() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $userId = $_SESSION['user_id'] ?? null;
    $user = User::findById($userId);

    $data = [
      'title' => 'Painel do usuário',
      'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'verified' => $user->verified
      ]
    ];
    $this->render('account', $data);
  }

  public function editName() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $errorMessage = $_SESSION['error_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $userId = $_SESSION['user_id'] ?? null;
    $user = User::findById($userId);

    $data = [
      'title' => 'Alteração do nome',
      'name' => $user->name,
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    $this->render('change_name', $data);
  }

  public function updateName() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $name = filter_input(INPUT_POST, 'name');

      if (empty($name)) {
        $_SESSION['error_message'] = ValidationErrors::EMPTY_NAME_FIELD;
        redirectTo(BASE_URL . 'account/change_name');
      }

      $hasAnInvalidNameLength = !UserValidator::hasAValidNameLength($name);
      if ($hasAnInvalidNameLength) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_NAME_LENGTH;
        redirectTo(BASE_URL . 'account/change_name');
      }

      $userId = $_SESSION['user_id'] ?? null;
      User::findByIdAndUpdate($userId, ['name' => $name]);

      redirectTo(BASE_URL . 'account');
    }
  }

  public function editEmail() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $errorMessage = $_SESSION['error_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $userId = $_SESSION['user_id'] ?? null;
    $user = User::findById($userId);

    $data = [
      'title' => 'Alteração do e-mail',
      'email' => $user->email,
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    $this->render('change_email', $data);
  }

  public function updateEmail() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $email = filter_input(INPUT_POST, 'email');

      if (empty($email)) {
        $_SESSION['error_message'] = ValidationErrors::EMPTY_EMAIL_FIELD;
        redirectTo(BASE_URL . 'account/change_email');
      }

      $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
      if ($isAnInvalidEmail) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_EMAIL_FORMAT;
        redirectTo(BASE_URL . 'account/change_email');
      }

      $user = User::findByEmail($email);

      $emailAlreadyInUse = !empty($user);
      if ($emailAlreadyInUse) {
        $_SESSION['error_message'] = AccountErrors::EMAIL_ALREADY_IN_USE;
        redirectTo(BASE_URL . 'account/change_email');
      }

      $userId = $_SESSION['user_id'] ?? null;
      User::findByIdAndUpdate($userId, ['email' => $email, 'verified' => false]);

      $emailVerificationPage = BASE_URL . "send_verification_email?email={$email}";
      redirectTo($emailVerificationPage);
    }
  }

  public function editPassword() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $errorMessage = $_SESSION['error_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'title' => 'Alteração da senha',
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    $this->render('change_password', $data);
  }

  public function updatePassword() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $userId = $_SESSION['user_id'] ?? null;
      $user = User::findById($userId);

      $currentPassword = filter_input(INPUT_POST, 'currentPassword');
      $newPassword = filter_input(INPUT_POST, 'newPassword');
      $newRepeatedPassword = filter_input(INPUT_POST, 'repeatedPassword');

      $areTheFieldsEmpty = empty($currentPassword) || empty($newPassword) || empty($newRepeatedPassword);
      if ($areTheFieldsEmpty) {
        $_SESSION['error_message'] = ValidationErrors::EMPTY_FIELDS;
        redirectTo(BASE_URL . 'account/change_password');
      }

      $isThePasswordIncorrect = !password_verify($currentPassword, $user->password);
      if ($isThePasswordIncorrect) {
        $_SESSION['error_message'] = AccountErrors::INCORRECT_PASSWORD;
        redirectTo(BASE_URL . 'account/change_password');
      }

      $hasAnInvalidPasswordLength = !UserValidator::hasAValidPasswordLength($newPassword);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_PASSWORD_LENGTH;
        redirectTo(BASE_URL . 'account/change_password');
      }

      $passwordsAreDifferent = $newPassword !== $newRepeatedPassword;
      if ($passwordsAreDifferent) {
        $_SESSION['error_message'] = ValidationErrors::DIFFERENT_PASSWORDS;
        redirectTo(BASE_URL . 'account/change_password');
      }

      $hashedPassword = password_hash($newPassword, PASSWORD_HASH);
      User::findByIdAndUpdate($userId, ['password' => $hashedPassword]);

      redirectTo(BASE_URL . 'account');
    }
  }
}
