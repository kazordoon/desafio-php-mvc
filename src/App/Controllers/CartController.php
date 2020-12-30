<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class CartController extends Controller {
  public function calculateTotalPrice($products = []) {
    $totalPrice = 0;
    foreach ($products as $product) {
      $totalPrice += $product->price * $product->quantity;
    }

    return $totalPrice;
  }


  public function index() {
    $this->redirectToLoginPageIfNotLoggedIn();

    $cart = $_SESSION['cart'] ?? [];
    $products = $cart['products'] ?? [];

    $productsCopy = [];
    foreach ($products as $product) {
      $productsCopy[] = cloneClass($product);
    }

    foreach ($productsCopy as $product) {
      $product->total = formatPrice(
        $product->price * $product->quantity
      );
      $product->price = formatPrice($product->price);
    }

    $totalPrice = $this->calculateTotalPrice($products);
    $_SESSION['cart']['total_price'] = $totalPrice;
    $formattedTotalPrice = formatPrice($totalPrice);

    $data = [
      'title' => 'Carrinho',
      'products' => $productsCopy,
      'total_price' => $formattedTotalPrice
    ];

    $this->render('cart', $data);
  }

  public function store() {
    $this->redirectToLoginPageIfNotLoggedIn();

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
    $this->redirectToLoginPageIfNotLoggedIn();

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
    $this->redirectToLoginPageIfNotLoggedIn();

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
