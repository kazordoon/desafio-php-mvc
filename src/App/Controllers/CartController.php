<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class CartController extends Controller {
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

    $data = ['products' => $products];

    $this->render('cart', $data);
  }

  public function store() {
    $this->redirectIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];

    $productIds = filter_input(INPUT_POST, 'productsIds');
    $productIds = explode(',', $productIds);

    foreach ($productIds as $productId) {
      $product = Product::findById($productId);
      $products[$productId] = $product;
    }

    $_SESSION['cart']['products'] = $products;
    exit(json_encode($products));
  }
}