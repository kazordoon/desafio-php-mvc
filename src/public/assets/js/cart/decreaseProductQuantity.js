import convertCurrencyToNumber from '../utils/convertCurrencyToNumber.js';
import formatPrice from '../utils/formatPrice.js';
import showUpdatedTotalPrice from './showUpdatedTotalPrice.js';

export default function decreaseProductQuantity(event) {
  const productTotalPriceElement = event.target.parentElement.nextElementSibling;
  const productPriceElement = event.target.parentElement.previousElementSibling;
  const productQuantitiesElement = event.target.nextElementSibling;

  const productQuantities = parseInt(productQuantitiesElement.value, 10);
  const productPrice = parseFloat(productPriceElement.textContent);
  const decreasedValue = productQuantities - 1;

  const minQuantity = productQuantitiesElement.getAttribute('min');
  if (decreasedValue < minQuantity) {
    return;
  }

  let productTotalPrice = convertCurrencyToNumber(productTotalPriceElement.textContent);
  productTotalPrice -= productPrice;
  productTotalPrice = formatPrice(productTotalPrice);

  productTotalPriceElement.textContent = productTotalPrice;

  productQuantitiesElement.value = decreasedValue;

  showUpdatedTotalPrice();
}
