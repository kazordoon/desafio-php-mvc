import convertCurrencyToNumber from '../utils/convertCurrencyToNumber.js';
import formatPrice from '../utils/formatPrice.js';
import showUpdatedTotalPrice from './showUpdatedTotalPrice.js';

export default function increaseProductQuantity(event) {
  const productTotalPriceElement = event.target.parentElement.nextElementSibling;
  const productPriceElement = event.target.parentElement.previousElementSibling;
  const productQuantitiesElement = event.target.previousElementSibling;

  const productQuantities = parseInt(productQuantitiesElement.value, 10);
  const productPrice = parseFloat(productPriceElement.textContent);
  const increasedValue = productQuantities + 1;

  const maxQuantity = productQuantitiesElement.getAttribute('max');
  if (increasedValue > maxQuantity) {
    return;
  }

  let productTotalPrice = convertCurrencyToNumber(productTotalPriceElement.textContent);
  productTotalPrice += productPrice;
  productTotalPrice = formatPrice(productTotalPrice);

  productTotalPriceElement.textContent = productTotalPrice;

  productQuantitiesElement.value = increasedValue;

  showUpdatedTotalPrice();
}
