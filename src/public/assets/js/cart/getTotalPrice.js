import convertCurrencyToNumber from '../utils/convertCurrencyToNumber.js';

export default function getTotalPrice() {
  const totalPrice = [...document.querySelectorAll('.product-total')]
    .map((productTotal) => productTotal.textContent)
    .map(convertCurrencyToNumber)
    .reduce((total, productPrice) => total + productPrice);

  return totalPrice;
}
