<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\MailErrors;
use App\Models\User;
use PHPMailer\PHPMailer\Exception;

class EmailCheckSendingController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

    if (!$email) {
      redirectTo(BASE_URL . 'login');
    }

    $foundUser = User::findByEmail($email);

    $userNotFound = !$foundUser;
    if ($userNotFound) {
      redirectTo(BASE_URL . 'login');
    }

    $hasTheEmailBeenVerified = $foundUser->verified;
    if ($hasTheEmailBeenVerified) {
      redirectTo(BASE_URL . 'login');
    }

    $emailVerificationToken = generateToken();
    User::findByIdAndUpdate($foundUser->id, [
      'email_verification_token' => $emailVerificationToken
    ]);

    $user = new User;
    $user->name = $foundUser->name;
    $user->email = $email;

    try {
      sendEmailVerificationLink($user, $emailVerificationToken);
    } catch (Exception $e) {
      $_SESSION['error_message'] = MailErrors::EMAIL_NOT_SENT;
      redirectTo(BASE_URL . 'login');
    }

    $data = [
      'email' => $email
    ];
    $this->render('send_verification_email', $data);
  }
}
