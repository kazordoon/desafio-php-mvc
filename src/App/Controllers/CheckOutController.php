<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\PurchaseErrors;
use App\Errors\ValidationErrors;
use App\Models\Product;
use App\Models\Purchase;
use App\Validators\CreditCardValidator;

class CheckOutController extends Controller {
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
    $this->redirectIfNotLoggedIn();

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
    $formattedTotalPrice = formatPrice($totalPrice);

    $errorMessage = $_SESSION['error_message'] ?? null;

    $data = [
      'title' => 'Checkout',
      'products' => $productsCopy,
      'total_price' => $formattedTotalPrice,
      'error_message' => $errorMessage
    ];

    clearSessionMessages();

    $this->render('checkout', $data);
  }

  public function store() {
    $this->redirectIfNotLoggedIn();

    $creditCardOwner = filter_input(INPUT_POST, 'creditCardOwner');
    $creditCardNumber = filter_input(INPUT_POST, 'creditCardNumber');
    $creditCardExpirationDate = filter_input(INPUT_POST, 'creditCardExpirationDate');
    $creditCardCode = filter_input(INPUT_POST, 'creditCardCode');

    $hasEmptyFields = empty($creditCardOwner)
      || empty($creditCardNumber)
      || empty($creditCardExpirationDate)
      || empty($creditCardCode);
    if ($hasEmptyFields) {
      $_SESSION['error_message'] = ValidationErrors::EMPTY_FIELDS;
      redirectTo(BASE_URL . 'checkout');
    }

    $isAnInvalidCardNumber = !CreditCardValidator::validateCreditCardNumber($creditCardNumber);
    if ($isAnInvalidCardNumber) {
      $_SESSION['error_message'] = PurchaseErrors::INVALID_CREDIT_CARD_NUMBER;
      redirectTo(BASE_URL . 'checkout');
    }

    $isAnInvalidCardExpirationDate = !CreditCardValidator::validateCreditCardExpirationDate(
      $creditCardExpirationDate
    );
    if ($isAnInvalidCardExpirationDate) {
      $_SESSION['error_message'] = PurchaseErrors::INVALID_CREDIT_CARD_EXPIRATION_DATE;
      redirectTo(BASE_URL . 'checkout');
    }

    $isAnInvalidCardCode = !CreditCardValidator::validateCreditCardCode($creditCardCode);
    if ($isAnInvalidCardCode) {
      $_SESSION['error_message'] = PurchaseErrors::INVALID_CREDIT_CARD_CODE;
      redirectTo(BASE_URL . 'checkout');
    }

    $userId = $_SESSION['user_id'];
    $cart = $_SESSION['cart'] ?? [];
    $cartProducts = $cart['products'] ?? [];

    $creditCardAsPaymentMethod = 1;

    foreach ($cartProducts as $cartProduct) {
      $product = Product::findById($cartProduct->id);
      $updatedStock = $product->stock - $cartProduct->quantity;

      $purchase = [
        'user_id' => $userId,
        'payment_method_id' => $creditCardAsPaymentMethod,
        'product_id' => $product->id,
        'quantity' => $cartProduct->quantity
      ];

      Purchase::create($purchase);
      Product::findByIdAndUpdate($product->id, ['stock' => $updatedStock]);
    }

    unset($_SESSION['cart']);

    $_SESSION['success_message'] = 'Sua compra foi efetuada com sucesso.';
    redirectTo(BASE_URL . 'products');
  }
}
