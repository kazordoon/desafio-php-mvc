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

    $isTheUserLoggedIn = isset($_SESSION['user_id']);
    $data = [
      'title' => 'Produtos',
      'cart' => $cart,
      'products' => $products,
      'logged_in' => $isTheUserLoggedIn
    ];

    $this->render('products', $data);
  }
}
