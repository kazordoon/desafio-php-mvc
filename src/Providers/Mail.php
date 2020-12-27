<?php

namespace App\Providers;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;

class Mail {
  private PHPMailer $mail;

  public function __construct() {
    $this->loadSettings();
  }

  private function loadSettings() {
    $this->mail = new PHPMailer();

    $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
    $this->mail->SMTPAuth = true;
    $this->mail->isSMTP();

    $this->mail->Host = MAIL_HOST;
    $this->mail->Port = MAIL_PORT;

    $this->mail->Username = MAIL_USERNAME;
    $this->mail->Password = MAIL_PASSWORD;

    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $this->mail->setFrom(MAIL_EMAIL_ADDRESS, MAIL_NAME);
    $this->mail->isHTML(false);
    $this->mail->CharSet = 'UTF-8';
  }

  public function setRecipient(string $address, string $name) {
    $this->mail->addAddress($address, $name);
  }

  public function writeContent(string $subject, string $content) {
    $this->mail->Subject = $subject;
    $this->mail->Body = $content;
    $this->mail->AltBody = strip_tags($content);
  }

  public function send() {
    $this->mail->send();
  }
}
