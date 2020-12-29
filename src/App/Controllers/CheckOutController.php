<?php

namespace App\Controllers;

use App\Core\Controller;

class CheckOutController extends Controller {
  public function redirectIfNotLoggedIn() {
    $isNotLoggedIn = !isset($_SESSION['user_id']);

    if ($isNotLoggedIn) {
      redirectTo(BASE_URL . 'login');
    }
  }

  public function index() {
    $this->redirectIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];
    $totalPrice = $cart['total_price'] ?? [];

    $formattedTotalPrice = formatPrice($totalPrice);

    $data = [
      'title' => 'Checkout',
      'products' => $products,
      'total_price' => $formattedTotalPrice
    ];

    $this->render('checkout', $data);
  }
}
