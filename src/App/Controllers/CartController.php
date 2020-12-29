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

  public function calculateTotalPrice($products = []) {
    $totalPrice = 0;
    foreach ($products as $product) {
      $totalPrice += $product->price * $product->quantity;
    }

    return $totalPrice;
  }


  public function index() {
    // TODO: Formatar preço ao listar produtos no carrinho
    $this->redirectIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];

    $totalPrice = $this->calculateTotalPrice($products);

    $_SESSION['cart']['total_price'] = $totalPrice;

    $formattedTotalPrice = formatPrice($totalPrice);

    $data = [
      'title' => 'Carrinho',
      'products' => $products,
      'total_price' => $formattedTotalPrice
    ];

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
      $products[$productId]->quantity = 1;
    }

    $_SESSION['cart']['products'] = $products;
    exit(json_encode($products));
  }

  public function destroy($params) {
    $this->redirectIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];
    $productId = $params['id'];

    $productIsNotOnTheCart = !isset($products[$productId]);
    if ($productIsNotOnTheCart) {
      return;
    }

    $filteredProducts = array_filter($products, function ($product) use ($productId) {
      return $product->id !== $productId;
    });

    $_SESSION['cart']['products'] = $filteredProducts;
  }

  public function addProductQuantity() {
    $this->redirectIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];

    // id=quantidade;id=quantidade
    $productsQuantities = filter_input(INPUT_POST, 'products');
    $productsQuantities = explode(';', $productsQuantities);

    foreach ($productsQuantities as $product) {
      [$id, $quantity] = explode('=', $product);
      $products[$id]->quantity = $quantity;
    }

    $_SESSION['cart']['products'] = $products;
  }
}
