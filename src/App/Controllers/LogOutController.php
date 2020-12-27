<?php

namespace App\Controllers;

use App\Core\Controller;

class LogOutController extends Controller {
  public function index() {
    $isTheUserLoggedIn = $_SESSION['user_id'] ?? null;

    if ($isTheUserLoggedIn) {
      session_destroy();
    }

    redirectTo(BASE_URL . 'login');
  }
}
