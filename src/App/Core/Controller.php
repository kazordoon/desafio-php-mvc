<?php

namespace App\Core;

use Twig\Extra\Intl\IntlExtension;
use Throwable;

abstract class Controller {
  public function render(string $viewName, array $viewData = []): void {
    try {
      $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Views');
      $twig = new \Twig\Environment($loader);
      $twig->addExtension(new IntlExtension());

      $template = $twig->load("{$viewName}.twig");
      $templateRendering = $template->render($viewData);

      echo $templateRendering;
    } catch (Throwable $e) {
      exit('Page not found.');
    }
  }

  public function redirectToLoginPageIfNotLoggedIn() {
    $isNotLoggedIn = !isset($_SESSION['user_id']);

    if ($isNotLoggedIn) {
      redirectTo(BASE_URL . 'login');
    }
  }

  public function redirectToAccountPageIfLoggedIn() {
    $isTheUserLoggedIn = isset($_SESSION['user_id']);
    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL . 'account');
    }
  }
}
