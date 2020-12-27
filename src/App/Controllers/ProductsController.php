<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ProductsController extends Controller {
  public function index() {
    $products = Product::findAll();

    foreach ($products as $product) {
      $product->price = formatPrice($product->price);
    }

    $data = [
      'products' => $products
    ];

    $this->render('products', $data);
  }
}