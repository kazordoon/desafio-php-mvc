<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ProductsController extends Controller {
  public function index() {
    $products = Product::findAvailable();
    $cart = $_SESSION['cart'] ?? [];

    foreach ($products as $product) {
      $product->price = formatPrice($product->price);
    }

    $successMessage = $_SESSION['success_message'] ?? null;

    $isTheUserLoggedIn = isset($_SESSION['user_id']);
    $data = [
      'title' => 'Produtos',
      'success_message' => $successMessage,
      'cart' => $cart,
      'products' => $products,
      'logged_in' => $isTheUserLoggedIn
    ];

    clearSessionMessages();

    $this->render('products', $data);
  }
}
