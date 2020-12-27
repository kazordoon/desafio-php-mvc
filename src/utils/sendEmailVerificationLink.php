<?php

use App\Models\User;
use App\Providers\Mail;

function sendEmailVerificationLink(User $user, string $token) {
  $emailVerificationLink = BASE_URL . "verify_email?email={$user->email}&token={$token}";
  $mailMessageContent = "Acesse o seguinte link para confirmar seu e-mail: {$emailVerificationLink}";
  $mail = new Mail;
  $mail->setRecipient($user->email, $user->name);
  $mail->writeContent('Confirme seu e-mail', $mailMessageContent);
  $mail->send();
}
